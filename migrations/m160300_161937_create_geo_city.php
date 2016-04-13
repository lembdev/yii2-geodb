<?php
/**
 * @author    Alexander Vizhanov <lembadm@gmail.com>
 * @copyright 2016 AstwellSoft <astwellsoft.com>
 * @package   lembadm\geodb
 */

use yii\db\Migration;

class m160300_161937_create_geo_city extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('geo_city', [
            'id'          => $this->primaryKey(),
            'country_id'  => $this->integer()->notNull(),
            'region_id'   => $this->integer(),
            'timezone_id' => $this->integer()->notNull(),
            'name'        => $this->string(130)->notNull(),
            'latitude'    => $this->decimal(12, 9),
            'longitude'   => $this->decimal(12, 9),
            'population'  => $this->integer(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        $this->addForeignKey('fk_city_country',
            'geo_city', 'country_id',
            'geo_country', 'id',
            'CASCADE', 'CASCADE'
        );

        $this->addForeignKey('fk_city_region',
            'geo_city', 'region_id',
            'geo_region', 'id',
            'CASCADE', 'CASCADE'
        );

        $this->addForeignKey('fk_city_timezone',
            'geo_city', 'timezone_id',
            'geo_timezone', 'id',
            'CASCADE', 'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('geo_city');
    }
}
