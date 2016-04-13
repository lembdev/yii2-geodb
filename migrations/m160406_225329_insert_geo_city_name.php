<?php
/**
 * @author    Alexander Vizhanov <lembadm@gmail.com>
 * @copyright 2016 AstwellSoft <astwellsoft.com>
 * @package   lembadm\geodb
 */

use lembadm\geodb\components\ImportTrait;
use yii\db\Migration;

class m160406_225329_insert_geo_city_name extends Migration
{
    use ImportTrait;

    public function up()
    {
        $this->import('geo_city_name', [
            'country_id',
            'region_id',
            'city_id',
            'name',
        ]);
    }

    public function down()
    {
        $this->execute('SET FOREIGN_KEY_CHECKS = 0;');
        $this->delete('geo_city_name');
        $this->execute('SET FOREIGN_KEY_CHECKS = 1;');
    }
}
