<?php
/**
 * @author    Alexander Vizhanov <lembadm@gmail.com>
 * @copyright 2015 AstwellSoft <astwellsoft.com>
 * @package   lembadm\geodb
 */

namespace lembadm\geodb\controllers;

use lembadm\geodb\models\City;
use lembadm\geodb\models\CityName;
use lembadm\geodb\models\Country;
use lembadm\geodb\models\Region;
use yii\db\Query;
use yii\rest\Controller;

/**
 * Class SelectApiController
 */
class SelectApiController extends Controller
{
    /**
     * @param string|null $q
     * @param int|null    $id
     *
     * @return array
     */
    public function actionCountries($q = null, $id = null)
    {
        if ($id) {
            return [
                'results' => [
                    'id'   => (int)$id,
                    'text' => Country::findOne((int)$id)->name
                ]
            ];
        }

        $data = (new Query)
            ->select('id, name AS text')
            ->from(Country::tableName())
            ->orderBy(['name' => SORT_DESC])
            ->limit(50);

        if ($q) {
            $data->where(['like', 'name', $q . '%', false]);
        }

        return [
            'results' => array_values($data->createCommand()->queryAll())
        ];
    }

    /**
     * @param string|null $q
     * @param int|null    $id
     * @param int|null    $country_id
     *
     * @return array
     */
    public function actionRegions($q = null, $id = null, $country_id = null)
    {
        if ($id) {
            return [
                'results' => [
                    'id'   => (int)$id,
                    'text' => Region::findOne((int)$id)->name
                ]
            ];
        }

        $data = (new Query)
            ->select('id, name AS text')
            ->from(Region::tableName())
            ->limit(50);

        if ($q) {
            $data->where([
                'or',
                ['like', 'name', $q . '%', false],
                ['like', 'name_ascii', $q . '%', false],
            ]);
        }

        if ($country_id) {
            $data->andWhere(['country_id' => (int)$country_id]);
        }

        return [
            'results' => array_values($data->createCommand()->queryAll())
        ];
    }

    /**
     * @param string|null $q
     * @param int|null    $id
     * @param int|null    $country_id
     * @param int|null    $region_id
     *
     * @return array
     */
    public function actionCities($q = null, $id = null, $country_id = null, $region_id = null)
    {
        if ($id) {
            return [
                'results' => [
                    'id'   => (int)$id,
                    'text' => City::findOne((int)$id)->name
                ]
            ];
        }

        if ($q) {
            $data = (new Query)
                ->select('c.id AS id, c.name AS text')
                ->from(CityName::tableName() . ' cn')
                ->innerJoin(City::tableName() . ' c', 'c.id = cn.city_id')
                ->where(['like', 'cn.name', $q . '%', false])
                ->groupBy('cn.city_id')
                ->limit(50);

            if ($country_id) {
                $data->andWhere(['cn.country_id' => $country_id]);
            }

            if ($region_id) {
                $data->andWhere(['cn.region_id' => $region_id]);
            }
        } else {
            $data = (new Query)
                ->select('id, name AS text')
                ->from(City::tableName())
                ->limit(50);

            if ($country_id) {
                $data->andWhere(['country_id' => $country_id]);
            }

            if ($region_id) {
                $data->andWhere(['region_id' => $region_id]);
            }
        }

        return [
            'results' => array_values($data->createCommand()->queryAll())
        ];
    }
}