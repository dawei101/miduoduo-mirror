<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
$this->title = '米多多兼职平台';
?>
<!-- InstanceBeginEditable name="EditRegion3" -->
<div class="body-box">
<div class="midd-kong"></div>
<div class="container">
  <div class="row">
    <div class="fabu-box padding-0">
      <div class="col-sm-12 col-md-2 col-lg-2 padding-0" style="background:#f00">
        <div class="qiye-left">
          <dl>
            <dt class="default-title"><i class="iconfont">&#xe609;</i>我要发布</dt>
          </dl>
          <dl>
            <dt class="default-title"><i class="iconfont">&#xe612;</i>职位管理</dt>
            <dd class="default-lis"><a href="/task">全部</a></dd>
            <dd class="default-lis"><a href="/task?status=0">显示中</a></dd>
            <dd class="default-lis"><a href="/task?status=30">审核中</a></dd>
            <dd class="default-lis"><a href="/task?status=40">审核未通过</a></dd>
          </dl>
          <dl class="default-title">
            <dt class="default-title"><i class="iconfont">&#xe60c;</i>简历管理</dt>
            <dd class="default-lis"><a href="/resume">全部</a></dd>
            <dd class="default-lis"><a href="/resume?status=10">已接受</a></dd>
            <dd class="default-lis"><a href="/resume?status=0">未处理</a></dd>
          </dl>
          <dl class="pitch-current">
            <dt class="default-title"><i class="iconfont">&#xe60b;</i>用户中心</dt>
            <dd class="default-lis"><a href="/user/info">我的资料</a></dd>
            <dd class="current"><a href="/user/account">修改密码</a></dd>
            <dd class="default-lis"><a href="/user/personal-cert">个人认证</a></dd>
            <dd class="default-lis"><a href="/user/corp-cert">企业认证</a></dd>
          </dl>
        </div>
      </div>
      <div class="col-sm-12 col-md-10 col-lg-10 padding-0 ">
        <div class="right-center">
            <div class="conter-title">我的账号</div>
        <?php if($errmsg){?>
        <div class="error-message"><?=$errmsg?></div>
        <?php }?>
        <?php $form = ActiveForm::begin();?>
          <ul class="tianxie-box" style="border:none">
              <li>
                <div class="pull-left title-left text-center">当前密码</div>
                <div class="pull-left right-box">
                  <input name="old_password" type="password" placeholder="输入当前密码">
                </div>
              </li>
              <li>
                <div class="pull-left title-left text-center">新设密码</div>
                <div class="pull-left right-box">
                  <input name="new_password" type="password" placeholder="输入您的新密码">
                </div>
              </li>
              <li>
                <div class="pull-left title-left text-center">确认密码</div>
                <div class="pull-left right-box">
                  <input name="confirm" type="password" placeholder="再次输入您的新密码">
                </div>
              </li>
                <button class="queding-bt">确定</button>
           </ul>
        <?php ActiveForm::end(); ?>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- InstanceEndEditable -->
