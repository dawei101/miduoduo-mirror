<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \corp\models\PasswordResetRequestForm */

$this->title = 'Request password reset';
$this->params['breadcrumbs'][] = $this->title;
?>

<!-- InstanceBeginEditable name="EditRegion3" -->
<div class="midd-kong"></div>
<div class="container mima">
  <div class="row">
    <div class="col-sm-12 col-md-12 col-lg-12 ">
      <div class="miam-coter">
      <h2>找回密码</h2>
      <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>
        <div class="midd-input-group">
          <input name="username" type="text" class="pull-left"  placeholder="请输入手机号">
          <span class="yz-btn pull-left text-center">获取验证码</span> </div>
        <div class="midd-input-group">
          <input name="password" type="text" class="input-q"  placeholder="请输入短信验证码">
        </div>
        <a href="#" class="zc-btn">下一步</a>
        </div>
      <?php ActiveForm::end(); ?>
    </div>
  </div>
</div>
<!-- InstanceEndEditable -->
