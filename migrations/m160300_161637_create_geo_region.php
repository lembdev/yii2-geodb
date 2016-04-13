<?php
/**
 * @author    Alexander Vizhanov <lembadm@gmail.com>
 * @copyright 2016 AstwellSoft <astwellsoft.com>
 * @package   lembadm\geodb
 */

use yii\db\Migration;

class m160300_161637_create_geo_region extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('geo_region', [
            'id'         => $this->primaryKey(),
            'country_id' => $this->integer()->notNull(),
            'name'       => $this->string(60)->notNull(),
            'name_ascii' => $this->string(60)->notNull(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        $this->addForeignKey('fk_region_country',
            'geo_region', 'country_id',
            'geo_country', 'id',
            'CASCADE', 'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('geo_region');
    }
}
