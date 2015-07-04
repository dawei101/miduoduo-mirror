<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \corp\models\PasswordResetRequestForm */

$this->title = '开通招聘服务';
$this->params['breadcrumbs'][] = $this->title;
?>

<!-- InstanceBeginEditable name="EditRegion3" -->
<div class="midd-kong"></div>
<div class="container mima">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 ">
            <div class="miam-coter">
                <h2>开通招聘服务</h2>
                <div class="box-jindu">
                    <div class="one1"></div>
                    <div class="one-n">1</div>
                    <div class="two-n1">2</div>
                    <div class="three-n1">3</div>
                    <div class="one-text">填写联系方式</div>
                    <div class="two-text1">提交公司信息</div>
                    <div class="three-text1">发布职位</div>
                </div>
                <form action="/user/add-contact-info" method="post">
                    <div class="tx-box">
                        <span class="pull-left text-right">企业名称 </span>
                        <div class="midd-input-group pull-left">
                            <input name="name" type="text" class="input-q"  placeholder="准确填写公司名，提升投递量">
                        </div>
                        <em class="pull-right">*</em>
                    </div>
                    <div class="tx-box">
                        <span class="pull-left text-right">联系人 </span>
                        <div class="midd-input-group pull-left">
                            <input name="contact" type="text" class="input-q"  placeholder="负责招聘的联系人姓名">
                        </div>
                        <em class="pull-right">*</em>
                    </div>
                    <div class="tx-box">
                        <span class="pull-left text-right">公司联系电话 </span>
                        <div class="midd-input-group pull-left">
                            <input name="phone" type="text" class="input-q"  placeholder="请填写真实有效手机/座机号码">
                        </div>
                        <em class="pull-right">*</em>
                    </div>
                    <div class="tx-box">
                        <span class="pull-left text-right"> 接收简历邮箱 </span>
                        <div class="midd-input-group pull-left">
                            <input name="email" type="text" class="input-q"  placeholder="请填写公司邮箱，审核通过后不可更改">
                        </div>
                        <em class="pull-right">*</em>
                    </div>
                    <div class="tx-box">
                        <span class="pull-left text-right"></span>
                        <a href="#" class="zc-btn pull-right">确定</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<!-- InstanceEndEditable -->
