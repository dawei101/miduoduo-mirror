<?php
use yii\helpers\Html;
use yii\bootstrap\ButtonGroup;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginWithDynamicCodeForm */

$this->title = '编辑简历';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-lg-8">
        <?php $form = ActiveForm::begin(['id' => 'edit-resume-form']); ?>
            <?= $form->field($model, 'name') ?>
            <?= $form->field($model, 'gender')
                ->dropDownList([0=>'保密', 1=>'男', 2=>'女'])?>
            <?= $form->field($model, 'grade')
                ->dropDownList([1=>'大一', 2=>'大二', 3=>'大三', 4=>'大四', 5=>'大五'])?>
            <div class="form-group">
                <?= Html::submitButton('下一步', ['class' => 'btn btn-danger col-xs-12', 'name' => 'login-button']) ?>
            </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
