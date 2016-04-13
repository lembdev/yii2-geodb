<?php
/**
 * @author    Alexander Vizhanov <lembadm@gmail.com>
 * @copyright 2015 AstwellSoft <astwellsoft.com>
 * @package   lembadm\geodb
 */

namespace lembadm\geodb\controllers;

use yii\rest\ActiveController;

/**
 * Class RestCountryController
 */
class RestCountryController extends ActiveController
{
    public $modelClass = 'lembadm\geodb\models\Country';
}