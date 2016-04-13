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
 * @property integer    $id                 ID
 * @property integer    $continent_id       Continent ID
 * @property integer    $capital_id         Capital ID
 * @property string     $iso                Country code ISO-3166
 * @property string     $iso3               Country code ISO 3166-1
 * @property string     $name               Name
 * @property string     $tld                Top-level domain
 * @property string     $currency_code      Currency code
 * @property string     $currency_name      Currency name
 * @property string     $phone              Phone format
 * @property string     $postal_code_format Postal Code Format
 * @property string     $postal_code_regex  Postal Code Regex
 *
 * @property City[]     $cities
 * @property CityName[] $citiesNames
 * @property City       $capital
 * @property Region[]   $regions
 */
class Country extends ActiveRecord
{
    const CONTINENT_AFRICA = 1;
    const CONTINENT_ASIA = 2;
    const CONTINENT_EUROPE = 3;
    const CONTINENT_NORTH_AMERICA = 4;
    const CONTINENT_OCEANIA = 5;
    const CONTINENT_SOUTH_AMERICA = 6;
    const CONTINENT_ANTARCTICA = 7;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'geo_country';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // continent_id
            ['continent_id', 'required'],
            ['continent_id', 'integer'],
            ['continent_id', 'in', 'range' => array_keys(self::getContinentsList())],

            // capital_id
            ['capital_id', 'integer'],
            ['capital_id', 'exist', 'targetClass' => City::className(), 'targetAttribute' => 'id'],

            // iso
            ['iso', 'required'],
            ['iso', 'string', 'max' => 2],

            // iso3
            ['iso3', 'required'],
            ['iso3', 'string', 'max' => 3],

            // name
            ['name', 'required'],
            ['name', 'string', 'max' => 45],

            // tld
            ['tld', 'string', 'max' => 3],

            // currency_code
            ['currency_code', 'string', 'max' => 3],

            // currency_name
            ['currency_name', 'string', 'max' => 15],

            // phone
            ['phone', 'string', 'max' => 20],

            // postal_code_format
            ['postal_code_format', 'string', 'max' => 55],

            // postal_code_regex
            ['postal_code_regex', 'string', 'max' => 155],
        ];
    }

    /**
     * Array of available continents
     *
     * @return array
     */
    public static function getContinentsList()
    {
        return [
            self::CONTINENT_AFRICA        => Yii::t('app', 'Africa'),
            self::CONTINENT_ASIA          => Yii::t('app', 'Asia'),
            self::CONTINENT_EUROPE        => Yii::t('app', 'Europe'),
            self::CONTINENT_NORTH_AMERICA => Yii::t('app', 'North America'),
            self::CONTINENT_OCEANIA       => Yii::t('app', 'Oceania'),
            self::CONTINENT_SOUTH_AMERICA => Yii::t('app', 'South America'),
            self::CONTINENT_ANTARCTICA    => Yii::t('app', 'Antarctica'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                 => Yii::t('app', 'ID'),
            'continent_id'       => Yii::t('app', 'Continent ID'),
            'capital_id'         => Yii::t('app', 'Capital ID'),
            'iso'                => Yii::t('app', 'ISO'),
            'iso3'               => Yii::t('app', 'ISO 3'),
            'name'               => Yii::t('app', 'Name'),
            'tld'                => Yii::t('app', 'TLD (top-level domain)'),
            'currency_code'      => Yii::t('app', 'Currency Code'),
            'currency_name'      => Yii::t('app', 'Currency Name'),
            'phone'              => Yii::t('app', 'Phone'),
            'postal_code_format' => Yii::t('app', 'Postal Code Format'),
            'postal_code_regex'  => Yii::t('app', 'Postal Code Regex'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCities()
    {
        return $this->hasMany(City::className(), ['country_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCitiesNames()
    {
        return $this->hasMany(CityName::className(), ['country_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCapital()
    {
        return $this->hasOne(City::className(), ['id' => 'capital_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegions()
    {
        return $this->hasMany(Region::className(), ['country_id' => 'id']);
    }
}
