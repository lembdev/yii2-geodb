<?php
/**
 * @author    Alexander Vizhanov <lembadm@gmail.com>
 * @copyright 2016 AstwellSoft <astwellsoft.com>
 * @package   lembadm\geodb
 */

namespace lembadm\geodb\components;

use yii;
use yii\base\ErrorException;
use ZipArchive;

/**
 * @mixin \yii\db\Migration
 */
trait ImportTrait
{
    /**
     * @var string Table name
     */
    private $table;

    /**
     * @var string Columns list (coma separated)
     */
    private $columns;

    /**
     * @var int Number of inserted rows per iteration
     */
    private $batchInsertLimit = 100000;

    /**
     * @var string Import file name
     */
    private $importFileName;

    /**
     * @var string Import file path
     */
    private $importFilePath;

    /**
     * @var int Value of `Yii::$app->log->flushInterval` before import
     */
    private $initialFlushInterval = 0;

    /**
     * @var array Value of `Yii::$app->log->targets` before import
     */
    private $initialLogTargets = [];

    /**
     * @param string $table   Table name
     * @param array  $columns Array of columns. Must match count and order of the columns in the import file
     *
     * @throws ErrorException
     */
    protected function import($table, array $columns)
    {
        $this->table = $table;
        $this->columns = implode(', ', $columns);

        try {
            $this->preImport();

            foreach ($this->getFileChunk() as $insertData) {
                $this->insertBatch($insertData);
            }
        } finally {
            $this->postImport();
        }
    }

    /**
     * Preparing to import
     * Change Yii logging settings, unpacking data to import
     *
     * @throws ErrorException
     */
    private function preImport()
    {
        // Backup Yii logging settings
        $this->initialFlushInterval = Yii::$app->log->flushInterval;
        $this->initialLogTargets = Yii::$app->log->targets;

        // Disable logging (memory leaks and reduces the HDD load)
        Yii::$app->log->flushInterval = 1;
        Yii::$app->log->targets = [];

        // Unpack the archived data to a temporary directory
        $zip = new ZipArchive;
        $res = $zip->open($this->getImportSrcPath());

        switch (true) {
            case $res === ZipArchive::ER_INCONS:
                throw new ErrorException('ZipArchive: Zip archive inconsistent.');
            case $res === ZipArchive::ER_MEMORY:
                throw new ErrorException('ZipArchive: Malloc failure.');
            case $res === ZipArchive::ER_NOENT:
                throw new ErrorException('ZipArchive: No such file.');
            case $res === ZipArchive::ER_NOZIP:
                throw new ErrorException('ZipArchive: Not a zip archive.');
            case $res === ZipArchive::ER_OPEN:
                throw new ErrorException("ZipArchive: Can't open file {$this->getImportSrcPath()}");
            case $res === ZipArchive::ER_READ:
                throw new ErrorException('ZipArchive: Read error.');
            case $res === ZipArchive::ER_SEEK:
                throw new ErrorException('ZipArchive: Seek error.');
        }

        $runtimePath = Yii::getAlias('@runtime');

        $this->importFileName = $zip->statIndex(0)['name'];
        $this->importFilePath = "{$runtimePath}/{$this->importFileName}";

        if (!$zip->extractTo($runtimePath, [$this->importFileName])) {
            throw new ErrorException("ZipArchive: Can't extract file to {$runtimePath}");
        }

        $zip->close();
    }

    /**
     * Restore after import
     * Remove temporary files, restore Yii logging settings
     */
    private function postImport()
    {
        // Delete the temporary data
        try {
            unlink($this->importFilePath);
        } catch (ErrorException $e) {}

        // Restore Yii logging settings
        Yii::$app->log->targets = $this->initialLogTargets;
        Yii::$app->log->flushInterval = $this->initialFlushInterval;
    }

    /**
     * Insert into Database
     *
     * @param string $data Part of the SQL INSERT VALUES syntax
     *
     * @throws yii\db\Exception
     */
    private function insertBatch($data)
    {
        $data = rtrim(rtrim($data), ',');

        $this->db->createCommand()
            ->setSql("INSERT INTO {$this->table} ({$this->columns}) VALUES {$data}")
            ->execute();
    }

    /**
     * Getting the full path to the file by the class name
     *
     * @return string Path to the archive data file
     */
    private function getImportSrcPath()
    {
        $calledClass = get_called_class();
        $classParts = explode('_', $calledClass);
        array_splice($classParts, 0, 3);

        return dirname(__DIR__) . '/data/' . implode('_', $classParts) . '.zip';
    }

    /**
     * Getting part of the data from the imported file
     *
     * @return \Generator
     * @throws ErrorException
     */
    private function getFileChunk()
    {
        $counter = $insertData = null;
        $handle = fopen($this->importFilePath, 'r');

        if (!$handle) {
            throw new ErrorException("fopen: can't open file {$this->importFilePath}");
        }

        while ($buffer = fgets($handle)) {
            $counter++;
            $insertData .= $buffer;
            unset($buffer);
            if ($counter === $this->batchInsertLimit) {
                yield $insertData;
                $insertData = $counter = null;
            }
        }

        if (!feof($handle)) {
            throw new ErrorException("fgets: unexpected end of file {$this->importFilePath}");
        }

        if ($counter) {
            yield $insertData;
        }

        fclose($handle);
    }
}