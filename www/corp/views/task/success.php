<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\bootstrap\ActiveForm;
use common\models\Task;
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
            <dt class="default-title"><i class="iconfont">&#xe609;</i><a href="/task/publish">我要发布</a></dt>
          </dl>
          <dl class="pitch-current">
            <dt class=""><i class="iconfont">&#xe612;</i>职位管理</dt>
            <dd class="<?=!array_key_exists('status', $_GET)?'current':'default-lis'?>"><a href="/task">全部</a></dd>
            <dd class="<?=array_key_exists('status', $_GET)&&$_GET['status']==0?'current':'default-lis'?>"><a href="/task?status=0">显示中</a></dd>
            <dd class="<?=array_key_exists('status', $_GET)&&$_GET['status']==30?'current':'default-lis'?>"><a href="/task?status=30">审核中</a></dd>
            <dd class="<?=array_key_exists('status', $_GET)&&$_GET['status']==40?'current':'default-lis'?>"><a href="/task?status=40">审核未通过</a></dd>
          </dl>
          <dl  class="default-title">
            <dt class="default-title"><i class="iconfont">&#xe60c;</i>简历管理</dt>
            <dd class="default-lis"><a href="/resume">全部</a></dd>
            <dd class="default-lis"><a href="/resume?status=10">已接受</a></dd>
            <dd class="default-lis"><a href="/resume?status=0">未处理</a></dd>
          </dl>
          <dl>
            <dt class="default-title"><i class="iconfont">&#xe60b;</i>用户中心</dt>
            <dd class="default-lis"><a href="/user/info">我的资料</a></dd>
            <dd class="default-lis"><a href="/user/account">修改密码</a></dd>
            <dd class="default-lis"><a href="/user/personal-cert">个人认证</a></dd>
            <dd class="default-lis"><a href="/user/corp-cert">企业认证</a></dd>
          </dl>
        </div>
      </div>
      <div class="col-sm-12 col-md-10 col-lg-10 padding-0 ">
        <div class="right-center">
            <div class="conter-title">发布兼职职位</div>
            <div class="fb-ts-tex"><img src="img/xialian.png" width="80" height="80">您的信息已经提交审核，审核通过后将自动发布</div>
            <div class="fb-ts-qrz">您还未通过身份审核，每天只能发布一条<a href="#">&nbsp;&nbsp;去认证&nbsp;&gt;</a></div>
            <!--<div class="btnn"><button class="fabu-btn">再发一条</button><button class="fabu-btn">预览</button></div>-->
            <div class="btnn"><span>再发一条</span>
              <button class="fabu-btn">预览</button>
            </div>
          </div>
      </div>
    </div>
  </div>
</div>
