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
 * @property integer      $country_id Country ID
 * @property integer|null $region_id  Region ID
 * @property integer      $city_id    City ID
 * @property string       $name       City name
 *
 * @property City         $city
 * @property Country      $country
 * @property Region       $region
 */
class CityName extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'geo_city_name';
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

            // region_id
            ['region_id', 'integer'],
            ['region_id', 'exist', 'targetClass' => Region::className(), 'targetAttribute' => 'id'],

            // city_id
            ['city_id', 'required'],
            ['city_id', 'integer'],
            ['city_id', 'exist', 'targetClass' => City::className(), 'targetAttribute' => 'id'],

            // name
            ['name', 'required'],
            ['name', 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'country_id' => Yii::t('app', 'Country ID'),
            'region_id'  => Yii::t('app', 'Region ID'),
            'city_id'    => Yii::t('app', 'City ID'),
            'name'       => Yii::t('app', 'Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::className(), ['id' => 'country_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(Region::className(), ['id' => 'region_id']);
    }
}
