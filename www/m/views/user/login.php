<?php
use yii\helpers\Html;
use yii\bootstrap\ButtonGroup;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginWithDynamicCodeForm */

$this->title = '密码登陆';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="">
<?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
    <div class="form-list">
      <?= $form->field($model, 'username')
          ->input('tel', $options = ['data-id'=>'phonenum'] ) ?>

      <?= $form->field($model, 'password')
          ->passwordInput() ?>
            </div>
    </div>

    <p class="block-btn">
        <?= Html::submitButton('登陆', ['class' => 'btn btn-primary btn-lg btn-block']) ?>
    </p>
<?php ActiveForm::end(); ?>
</div>


<?php $this->beginBlock('css') ?>
<style>
body {
    padding-top: 35%;
}

</style>
<?php $this->endBlock('css') ?>
