<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use dosamigos\tinymce\TinyMce;
use common\models\ServiceType;
use common\models\District;

/* @var $this yii\web\View */
/* @var $model common\models\Task */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="task-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'clearance_period')->dropDownList(
        $model::$CLEARANCE_PERIODS
    ) ?>
    <?= $form->field($model, 'company_name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'company_introduction')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'contact') ?>
    <?= $form->field($model, 'contact_phonenum') ?>

    <?= $form->field($model, 'salary')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'salary_unit')->dropDownList(
        $model::$SALARY_UNITS
    ) ?>

    <?= $form->field($model, 'salary_note')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'from_date')->widget(
        DatePicker::className(), [
            'model'=>$model,
            'attribute' => 'birthdate',
            'dateFormat' => 'yyyy-MM-dd',
        ]) ?>

    <?= $form->field($model, 'to_date')->widget(
        DatePicker::className(), [
            'model'=>$model,
            'attribute' => 'birthdate',
            'dateFormat' => 'yyyy-MM-dd',
        ]) ?>


    <?= $form->field($model, 'from_time')->textInput() ?>

    <?= $form->field($model, 'to_time')->textInput() ?>

    <?= $form->field($model, 'need_quantity')->textInput() ?>

    

    <?= $form->field($model, 'detail')->widget(
        TinyMce::className(), [
            'options' => ['rows' => 6],
            'language' => 'es',
            'clientOptions' => [
                'plugins' => [
                    "advlist autolink lists link charmap print preview anchor",
                    "searchreplace visualblocks code fullscreen",
                    "insertdatetime media table contextmenu paste"
                ],
                'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | image |"
            ]
        ]) ?>

    <?= $form->field($model, 'requirement')->textarea(['rows' => 6]) ?>


    <?php 

        $city_map = [];
        foreach(District::getCities() as $city){
            $city_map[$city->id] = $city->name;
        }
        $model->city_id = 3;

        $district_map = [];
        foreach(District::getDistricts($model->city_id) as $district){
            $district_map[$district->id] = $district->name;
        }
    ?>
        
    <?= $form->field($model, 'city_id')->dropDownList(
        $city_map
    ) ?>


    <?= $form->field($model, 'district_id')->dropDownList(
        $district_map
    ) ?>

    <?= $form->field($model, 'address')->textInput() ?>
    <?php
        $service_types = [];
        foreach (ServiceType::find()->all() as $t){
            $service_types[$t->id] = $t->name;
        }
    ?>
    <?= $form->field($model, 'service_type_id')->dropDownList(
        $service_types
    ) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
