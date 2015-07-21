<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
$this->title = '米多多兼职平台';
?>
<!-- InstanceBeginEditable name="EditRegion3" -->
<div class="body-box">
<div class="midd-kong"></div>
<div class="container">
  <div class="row">
    <div class="fabu-box padding-0">
      <div class="col-sm-2 padding-0">
        <div class="qiye-left">
          <dl>
            <dt class="default-title"><i class="iconfont">&#xe609;</i><a href="/task/publish">我要发布</a></dt>
          </dl>
          <dl>
            <dt  class="default-title" class=""><i class="iconfont">&#xe612;</i>职位管理</dt>
            <dd class="default-lis"><a href="/task">全部</a></dd>
            <dd class="default-lis"><a href="/task?status=0">显示中</a></dd>
            <dd class="default-lis"><a href="/task?status=30">审核中</a></dd>
            <dd class="default-lis"><a href="/task?status=40">审核未通过</a></dd>
          </dl>
          <dl  class="pitch-current">
            <dt class="default-title"><i class="iconfont">&#xe60c;</i>简历管理</dt>
            <dd class="<?=!array_key_exists('status', $_GET)?'current':'default-lis'?>"><a href="/resume">全部</a></dd>
            <dd class="<?=array_key_exists('status', $_GET)&&$_GET['status']==10?'current':'default-lis'?>"><a href="/resume?status=10">已接受</a></dd>
            <dd class="<?=array_key_exists('status', $_GET)&&$_GET['status']==0?'current':'default-lis'?>"><a href="/resume?status=0">未处理</a></dd>
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
      <div class="col-sm-10 padding-0 ">
        <div class="right-center">
          <div class="conter-title">简历管理</div>
            <dl class="jianli-lis">
                <dt class="tab-title">
                    <div class="pull-left tab1">应聘人</div>
                    <div class="pull-left tab2">应聘岗位</div>
                    <div class="pull-left tab3">联系方式</div>
                    <div class="pull-left tab4">投递时间</div>
                    <div class="pull-left tab5">操作</div>
                </dt>
                <?php foreach ($task_apps as $task_app) {?>
                <dd>
                    <div class="pull-left tab1 borser-tab-right">
                        <div class="names" aid="<?=$task_app->resume->id?>"><span style="float: left; display: block; line-height: 20px; padding: 0 10px;"><a href="<?=Yii::$app->params['baseurl.m']?>/resume-<?=$task_app->resume->id?>" target="blank"><?=$task_app->resume->name?></a></span></div>
                        <div class="jiben"><span><?=$task_app->resume->age?>岁</span><span><?=$task_app->resume->gender_label?></span><span><?=$task_app->resume->college?></span></div>
                    </div>
                    <div class="pull-left tab2 text-center borser-tab-right"><a href="<?=Yii::$app->params['baseurl.m']?>/task/view?gid=<?=$task_app->task->gid?>" target="blank"><?=$task_app->task->title?></a></div>
                    <div class="pull-left tab3 text-center borser-tab-right"><?=$task_app->resume->phonenum?></div>
                    <div class="pull-left tab4 text-center borser-tab-right"><?=$task_app->created_time?></div>
                    <?php if($task_app->status == $task_app::STATUS_WAIT_EXAMINE) {?>
                    <div class="pull-left tab5"><button class="pull-left jishou" aid="<?=$task_app->id?>">接受报名</button><button class="pull-left jujue" aid="<?=$task_app->id?>">不合适</button></div>
                    <?php  }else{?>
                    <div class="pull-left tab5"><div class="yijishou"><?=$task_app->status_label?></div></div>
                    <?php }?>
                </dd>
                <?php }?>
                <?=LinkPager::widget(['pagination' => $pagination])?>
<!--
                <div class="pagination pagers pull-right pagination-lg">
                      <a href="#" >&laquo;</a>
                      <a href="#" class="actives">1</a>
                      <a href="#">2</a>
                      <a href="#">3</a>
                      <a href="#">4</a>
                      <a href="#">5</a>
                      <a href="#">&raquo;</a>
                </div>
            -->
            </dl>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- InstanceEndEditable -->
<?php
$this->registerJsFile('/js/resume.js');
?>
