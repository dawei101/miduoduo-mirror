<?php
use yii\helpers\Html;
use yii\bootstrap\ButtonGroup;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginWithDynamicCodeForm */

$this->title = '欢迎登录';
$this->params['breadcrumbs'][] = $this->title;

$this->nav_left_link = 'javascript:window.history.back()';
$this->nav_right_link = '/user/vsignup';
$this->nav_right_title = '注册';

?>
<div class="">
<?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
    <div style='padding: 40px 0 10px 10px;color: #999;' > <?=$this->title?> </div>
    <div class="form-list">
      <?= $form->field($model, 'username')
          ->input('tel', $options = ['data-id'=>'phonenum'] ) ?>

      <?= $form->field($model, 'password')
          ->passwordInput() ?>
            </div>
    </div>

    <p class="block-btn">
        <?= Html::submitButton('登录', ['class' => 'btn btn-primary btn-lg btn-block']) ?>
    </p>
<?php ActiveForm::end(); ?>
</div>

