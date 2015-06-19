<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\OfflineOrderSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="offline-order-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'gid') ?>

    <?= $form->field($model, 'date') ?>

    <?= $form->field($model, 'worker_quntity') ?>

    <?= $form->field($model, 'fee') ?>

    <?php // echo $form->field($model, 'need_train') ?>

    <?php // echo $form->field($model, 'requirement') ?>

    <?php // echo $form->field($model, 'quality_requirement') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'pm_id') ?>

    <?php // echo $form->field($model, 'saleman_id') ?>

    <?php // echo $form->field($model, 'company') ?>

    <?php // echo $form->field($model, 'person_fee') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
