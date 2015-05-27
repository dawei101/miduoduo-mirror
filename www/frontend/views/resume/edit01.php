<?php
use yii\helpers\Html;
use yii\bootstrap\ButtonGroup;
use yii\bootstrap\ActiveForm;

use common\models\Resume;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginWithDynamicCodeForm */

$this->title = '简历录入';
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="row">
        <div class="col-lg-8">
            <?php $form = ActiveForm::begin(['id' => 'edit-resume-form']); ?>
                <?= $form->field($model, 'name') ?>
                <?= $form->field($model, 'gender')
                    ->dropDownList(Resume::$GENDERS)?>
                <?= $form->field($model, 'grade')
                    ->dropDownList(Resume::$GRADES)?>
                <?= ($model->isNewRecord)?$form->field($model, 'origin'):'' ?>
                <div class="form-group">
                    <?= Html::submitButton('下一步', ['class' => 'btn btn-danger col-xs-12', 'name' => 'login-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
