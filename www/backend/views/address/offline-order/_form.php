<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Address */
/* @var $form ActiveForm */
?>
<div class="offline-order-_form">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'id') ?>
        <?= $form->field($model, 'lat') ?>
        <?= $form->field($model, 'lng') ?>
        <?= $form->field($model, 'user_id') ?>
        <?= $form->field($model, 'belong_to') ?>
        <?= $form->field($model, 'province') ?>
        <?= $form->field($model, 'city') ?>
        <?= $form->field($model, 'district') ?>
        <?= $form->field($model, 'address') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- offline-order-_form -->
