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
 * @property integer      $id          ID
 * @property integer      $country_id  Country ID
 * @property integer|null $region_id   Region ID
 * @property integer      $timezone_id Timezone ID
 * @property string       $name        City name
 * @property string       $latitude    City latitude
 * @property string       $longitude   City longitude
 * @property integer      $population  City population
 *
 * @property Country      $country
 * @property Region       $region
 * @property Timezone     $timezone
 * @property CityName[]   $names
 */
class City extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'geo_city';
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

            // timezone_id
            ['timezone_id', 'integer'],
            ['timezone_id', 'exist', 'targetClass' => Timezone::className(), 'targetAttribute' => 'id'],

            // population
            ['population', 'integer'],

            // latitude
            ['latitude', 'number'],

            // longitude
            ['longitude', 'number'],

            // name
            ['name', 'required'],
            ['name', 'string', 'max' => 130],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'          => Yii::t('app', 'ID'),
            'country_id'  => Yii::t('app', 'Country ID'),
            'region_id'   => Yii::t('app', 'Region ID'),
            'timezone_id' => Yii::t('app', 'Timezone ID'),
            'name'        => Yii::t('app', 'Name'),
            'latitude'    => Yii::t('app', 'Latitude'),
            'longitude'   => Yii::t('app', 'Longitude'),
            'population'  => Yii::t('app', 'Population'),
        ];
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTimezone()
    {
        return $this->hasOne(Timezone::className(), ['id' => 'timezone_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNames()
    {
        return $this->hasMany(CityName::className(), ['city_id' => 'id']);
    }
}
