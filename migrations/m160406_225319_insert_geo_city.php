<?php
/**
 * @author    Alexander Vizhanov <lembadm@gmail.com>
 * @copyright 2016 AstwellSoft <astwellsoft.com>
 * @package   lembadm\geodb
 */

use lembadm\geodb\components\ImportTrait;
use yii\db\Migration;

class m160406_225319_insert_geo_city extends Migration
{
    use ImportTrait;

    public function up()
    {
        $this->import('geo_city', [
            'id',
            'country_id',
            'region_id',
            'timezone_id',
            'name',
            'latitude',
            'longitude',
            'population',
        ]);
    }

    public function down()
    {
        $this->execute('SET FOREIGN_KEY_CHECKS = 0;');
        $this->delete('geo_city');
        $this->execute('SET FOREIGN_KEY_CHECKS = 1;');
    }
}
