<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\WeichatUserInfo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="weichat-user-info-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'openid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'userid')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'created_time')->textInput() ?>

    <?= $form->field($model, 'updated_time')->textInput() ?>

    <?= $form->field($model, 'weichat_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'weichat_head_pic')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_receive_nearby_msg')->dropDownList(
        array(1=>'是',0=>'否')
    ) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
