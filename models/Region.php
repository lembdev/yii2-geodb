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
 * @property integer    $id         ID
 * @property integer    $country_id Country ID
 * @property string     $name       Name
 * @property string     $name_ascii Name (ascii)
 *
 * @property City[]     $cities
 * @property CityName[] $citiesNames
 * @property Country    $country
 */
class Region extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'geo_region';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // country_id
            ['country_id', 'required'],
            ['country_id', 'integer'],
            ['country_id', 'exist', 'targetClass' => Country::className(), 'targetAttribute' => 'id'],

            // name
            ['name', 'required'],
            ['name', 'string', 'max' => 60],

            // name_ascii
            ['name_ascii', 'required'],
            ['name_ascii', 'string', 'max' => 60],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'         => Yii::t('app', 'ID'),
            'country_id' => Yii::t('app', 'Country ID'),
            'name'       => Yii::t('app', 'Name'),
            'name_ascii' => Yii::t('app', 'Name Ascii'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCities()
    {
        return $this->hasMany(City::className(), ['region_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCitiesNames()
    {
        return $this->hasMany(CityName::className(), ['region_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::className(), ['id' => 'country_id']);
    }
}
