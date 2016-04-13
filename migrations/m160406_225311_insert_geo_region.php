<?php
/**
 * @author    Alexander Vizhanov <lembadm@gmail.com>
 * @copyright 2016 AstwellSoft <astwellsoft.com>
 * @package   lembadm\geodb
 */

use lembadm\geodb\components\ImportTrait;
use yii\db\Migration;

class m160406_225311_insert_geo_region extends Migration
{
    use ImportTrait;

    public function up()
    {
        $this->import('geo_region', [
            'id',
            'country_id',
            'name',
            'name_ascii',
        ]);
    }

    public function down()
    {
        $this->execute('SET FOREIGN_KEY_CHECKS = 0;');
        $this->truncateTable('geo_region');
        $this->execute('SET FOREIGN_KEY_CHECKS = 1;');
    }
}
