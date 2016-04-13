<?php
/**
 * @author    Alexander Vizhanov <lembadm@gmail.com>
 * @copyright 2016 AstwellSoft <astwellsoft.com>
 * @package   lembadm\geodb
 */

use lembadm\geodb\components\ImportTrait;
use yii\db\Migration;

class m160406_225128_insert_geo_timezone extends Migration
{
    use ImportTrait;

    public function up()
    {
        $this->import('geo_timezone', [
            'id',
            'name'
        ]);
    }

    public function down()
    {
        $this->execute('SET FOREIGN_KEY_CHECKS = 0;');
        $this->truncateTable('geo_timezone');
        $this->execute('SET FOREIGN_KEY_CHECKS = 1;');
    }
}
