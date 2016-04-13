<?php
/**
 * @author    Alexander Vizhanov <lembadm@gmail.com>
 * @copyright 2015 AstwellSoft <astwellsoft.com>
 * @package   lembadm\geodb
 */

namespace lembadm\geodb\models;

use yii;
use yii\db\ActiveRecord;

/**
 * @property integer $id   ID
 * @property string  $name Name
 *
 * @property City[]  $cities
 */
class Timezone extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'geo_timezone';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // name
            ['name', 'required'],
            ['name', 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'   => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCities()
    {
        return $this->hasMany(City::className(), ['timezone_id' => 'id']);
    }
}
