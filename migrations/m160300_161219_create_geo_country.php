<?php
/**
 * @author    Alexander Vizhanov <lembadm@gmail.com>
 * @copyright 2016 AstwellSoft <astwellsoft.com>
 * @package   lembadm\geodb
 */

use yii\db\Migration;

class m160300_161219_create_geo_country extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('geo_country', [
            'id'                 => $this->primaryKey(),
            'continent_id'       => $this->smallInteger(1)->notNull(),
            'capital_id'         => $this->integer(),
            'iso'                => $this->string(2)->notNull(),
            'iso3'               => $this->string(3)->notNull(),
            'name'               => $this->string(45)->notNull(),
            'tld'                => $this->string(3),
            'currency_code'      => $this->string(3),
            'currency_name'      => $this->string(15),
            'phone'              => $this->string(20),
            'postal_code_format' => $this->string(55),
            'postal_code_regex'  => $this->string(155),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('geo_country');
    }
}
