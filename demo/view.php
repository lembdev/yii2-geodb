<?php
/**
 * @author    Alexander Vizhanov <lembadm@gmail.com>
 * @copyright 2015 AstwellSoft <astwellsoft.com>
 * @package   lembadm\geodb
 */

use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \yii\base\Model */

/**
 * In this demo i use `kartik\select2\Select2` as example
 *
 * The region and city can be selected only if country already selected
 */

$this->registerJs(new JsExpression('
(function ($) {
    "use strict";

    $("#model-country_id").on("select2:selecting", function () {
        $("#model-region_id").removeAttr("disabled");
        $("#model-city_id").removeAttr("disabled");
    });
})(jQuery);
'));
?>
<?php $form = ActiveForm::begin() ?>

<?= $form->field($model, 'country_id')
    ->widget(kartik\select2\Select2::className(), [
        'data'          => [],
        'options'       => ['placeholder' => 'Select a Country ...'],
        'pluginOptions' => [
            'ajax' => [
                'url'      => Url::to('/geo/select-api/countries'),
                'dataType' => 'json',
                'data'     => new JsExpression('function(params) {return {q:params.term}}')
            ],
        ],
    ])
?>

<?= $form->field($model, 'region_id')
    ->widget(kartik\select2\Select2::className(), [
        'data'          => [],
        'options'       => ['placeholder' => 'Select a Region ...'],
        'disabled'      => true,
        'pluginOptions' => [
            'ajax' => [
                'url'      => Url::to('/geo/select-api/regions'),
                'dataType' => 'json',
                'data'     => new JsExpression('function(params) {return {
                    q: params.term, 
                    country_id: $("#model-country_id").val()
                }}')
            ],
        ],
    ])
?>

<?= $form->field($model, 'city_id')
    ->widget(kartik\select2\Select2::className(), [
        'data'          => [],
        'options'       => ['placeholder' => 'Select a City ...'],
        'disabled'      => true,
        'pluginOptions' => [
            'ajax' => [
                'url'      => Url::to('/geo/select-api/cities'),
                'dataType' => 'json',
                'data'     => new JsExpression('function(params) {return {
                    q:params.term,
                    country_id: $("#model-country_id").val(),
                    region_id: $("#model-region_id").val()
                }}')
            ],
        ],
    ])
?>

<?php ActiveForm::end() ?>