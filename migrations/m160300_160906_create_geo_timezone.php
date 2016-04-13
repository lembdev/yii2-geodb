<?php
/**
 * @author    Alexander Vizhanov <lembadm@gmail.com>
 * @copyright 2016 AstwellSoft <astwellsoft.com>
 * @package   lembadm\geodb
 */

use yii\db\Migration;

class m160300_160906_create_geo_timezone extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('geo_timezone', [
            'id'   => $this->primaryKey(),
            'name' => $this->string(30)->notNull(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('geo_timezone');
    }
}
