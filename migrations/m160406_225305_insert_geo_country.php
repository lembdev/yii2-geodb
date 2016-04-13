<?php
/**
 * @author    Alexander Vizhanov <lembadm@gmail.com>
 * @copyright 2016 AstwellSoft <astwellsoft.com>
 * @package   lembadm\geodb
 */

use lembadm\geodb\components\ImportTrait;
use yii\db\Migration;

class m160406_225305_insert_geo_country extends Migration
{
    use ImportTrait;

    public function up()
    {
        $this->import('geo_country', [
            'id',
            'continent_id',
            'capital_id',
            'iso',
            'iso3',
            'name',
            'tld',
            'currency_code',
            'currency_name',
            'phone',
            'postal_code_format',
            'postal_code_regex',
        ]);
    }

    public function down()
    {
        $this->execute('SET FOREIGN_KEY_CHECKS = 0;');
        $this->truncateTable('geo_country');
        $this->execute('SET FOREIGN_KEY_CHECKS = 1;');
    }
}
