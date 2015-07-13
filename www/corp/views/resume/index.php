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
      <div class="col-sm-12 col-md-2 col-lg-2 padding-0" style="background:#f00">
        <div class="qiye-left">
          <dl>
            <dt class="default-title"><i class="iconfont">&#xe609;</i>我要发布</dt>
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
            <dd class="<?=!array_key_exists('read', $_GET)?'current':'default-lis'?>"><a href="/resume">全部</a></dd>
            <dd class="<?=array_key_exists('read', $_GET)&&$_GET['read']==0?'current':'default-lis'?>"><a href="/resume?read=0">未查看</a></dd>
            <dd class="<?=array_key_exists('read', $_GET)&&$_GET['read']==1?'current':'default-lis'?>"><a href="/resume?read=1">已查看</a></dd>
          </dl>
          <dl>
            <dt class="default-title"><i class="iconfont">&#xe60b;</i>用户中心</dt>
            <dd class="default-lis"><a href="/user/info">我的资料</a></dd>
            <dd class="default-lis"><a href="/user/account">我的账号</a></dd>
            <dd class="default-lis"><a href="/user/personal-cert">个人认证</a></dd>
            <dd class="default-lis"><a href="/user/corp-cert">企业认证</a></dd>
          </dl>
        </div>
      </div>
      <div class="col-sm-12 col-md-10 col-lg-10 padding-0 ">
        <div class="right-center">
          <!--<div class="conter-title">发布兼职职位</div>-->
            <dl class="jianli-lis">
                <dt class="tab-title">
                    <div class="pull-left tab1">应聘人</div>
                    <div class="pull-left tab2">应聘岗位</div>
                    <div class="pull-left tab3">联系方式</div>
                    <div class="pull-left tab4">投递时间</div>
                    <div class="pull-left tab5">操作</div>
                </dt>
                <?php foreach ($resumes as $resume) {?>
                <dd>
                    <div class="pull-left tab1 borser-tab-right">
                        <div class="names" aid="<?=$resume['id']?>"><?=$resume['name']?></div>
                        <div class="jiben"><span><?=$resume['age']?>岁</span><span><?=($resume['gender']==0)?'男':'女'?></span><span><?=$resume['college']?></span></div>
                    </div>
                    <div class="pull-left tab2 text-center borser-tab-right"><?=$resume['title']?></div>
                    <div class="pull-left tab3 text-center borser-tab-right"><?=$resume['phonenum']?$resume['phonenum']:'&nbsp;'?></div>
                    <div class="pull-left tab4 text-center borser-tab-right"><?=$resume['created_time']?></div>
                    <div class="pull-left tab5"><button class="pull-left jishou" aid="<?=$resume['id']?>">接受报名</button><button class="pull-left jujue" aid="<?=$resume['id']?>">不合适</button></div>
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
