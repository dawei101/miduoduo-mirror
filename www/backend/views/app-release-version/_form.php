<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\AppReleaseVersion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="app-release-version-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'device_type')->textInput() ?>

    <?= $form->field($model, 'app_version')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'html_version')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'update_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'release_time')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
