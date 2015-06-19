<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use kartik\form\ActiveForm;
use yii\jui\DatePicker;

use common\models\OfflineOrder;

/* @var $this yii\web\View */
/* @var $model common\models\OfflineOrder */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="offline-order-form col-lg-8 col-xs-12 col-md-8">

    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]) ?>

    <?= $form->field($model, 'date')->widget(
        DatePicker::className(), [
            'model'=>$model,
            'attribute' => 'birthdate',
            'dateFormat' => 'yyyy-MM-dd',
        ]) ?>

    <?= $form->field($model, 'worker_quntity')->textInput(['type'=>'number', 'min'=>1]) ?>

    <?= $form->field($model, 'fee')->textInput(['maxlength' => true, 'type'=>'number', 'min'=>0.1, 'step'=>'0.1']) ?>

    <?= $form->field($model, 'person_fee')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'need_train')->checkBox() ?>

    <?= $form->field($model, 'status')->dropdownList(OfflineOrder::$STATUS_LABELS) ?>

    <?= $form->field($model, 'company')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'requirement')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'quality_requirement')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'pm_id')->textInput() ?>

    <?= ''//$form->field($model, 'saleman_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '修改', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
