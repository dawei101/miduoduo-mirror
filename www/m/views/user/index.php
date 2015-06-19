<?php
/* @var $this yii\web\View */
$this->title = '个人资料';

$this->nav_left_link = 'javascript:window.history.back()';
$this->nav_right_link = '/';
$this->nav_right_title = '首页';
?>
   <div class="tops">
        <div class="head-sculpture"><img src="/static/img/avatar.jpg" class="img-responsive img-circle"></div>
        <h4 class="text-center"><?=$resume?$resume->name:'你是谁？'?></h4>
   </div>
  <div class="list-lis">
        <a href="/resume/edit" class="list-group-item"><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>我的简历</a>
        <a href="/user/tasks" class="list-group-item"><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>已报名兼职</a>
  </div>
  <div class="list-lis">
        <a href="mailto:<?=\Yii::$app->params['supportEmail']?>" class="list-group-item">联系我们： <?= \Yii::$app->params['supportEmail']?> </a>
        <a class="list-group-item">我的邀请码：<?=\Yii::$app->user->id?></a>
  </div>

  <div class="list-lis">
        <a href="/user/logout" class="list-group-item"><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>退出登录</a>

  </div>


