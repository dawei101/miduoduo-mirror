<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

use common\models\ServiceType;

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

    <?= $form->field($model, 'got_quantity')->textInput() ?>

    <?= $form->field($model, 'created_time')->textInput() ?>

    <?= $form->field($model, 'updated_time')->textInput() ?>

    <?= $form->field($model, 'detail')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'requirement')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'address_id')->textInput() ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?php
        $service_types = [];
        foreach (ServiceType::find()->all() as $t){
            $service_types[$t->id] = $t->name;
        }
    ?>
    <?= $form->field($model, 'service_type_id')->dropDownList(
        $service_types
    ) ?>

    <?= $form->field($model, 'gender_requirement')->textInput() ?>

    <?= $form->field($model, 'degree_requirement')->textInput() ?>

    <?= $form->field($model, 'age_requirement')->textInput() ?>

    <?= $form->field($model, 'height_requirement')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'city_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
