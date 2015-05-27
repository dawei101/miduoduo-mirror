<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SuborderSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="suborder-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'order_id') ?>

    <?= $form->field($model, 'address_id') ?>

    <?= $form->field($model, 'from_time') ?>

    <?= $form->field($model, 'to_time') ?>

    <?= $form->field($model, 'quantity') ?>

    <?php // echo $form->field($model, 'got_qunatity') ?>

    <?php // echo $form->field($model, 'modified_by') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
