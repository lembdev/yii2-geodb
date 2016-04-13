<?php
/**
 * @author    Alexander Vizhanov <lembadm@gmail.com>
 * @copyright 2016 AstwellSoft <astwellsoft.com>
 * @package   lembadm\geodb
 */

use yii\db\Migration;

class m160300_162545_create_geo_city_name extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('geo_city_name', [
            'country_id' => $this->integer()->notNull(),
            'region_id'  => $this->integer(),
            'city_id'    => $this->integer()->notNull(),
            'name'       => $this->string()->notNull(),
            'PRIMARY KEY (`city_id`, `name`)'
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        $this->addForeignKey('fk_city_name_country',
            'geo_city_name', 'country_id',
            'geo_country', 'id',
            'CASCADE', 'CASCADE'
        );

        $this->addForeignKey('fk_city_name_region',
            'geo_city_name', 'region_id',
            'geo_region', 'id',
            'CASCADE', 'CASCADE'
        );

        $this->addForeignKey('fk_city_name_city',
            'geo_city_name', 'city_id',
            'geo_city', 'id',
            'CASCADE', 'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('geo_city_name');
    }
}
