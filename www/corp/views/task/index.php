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
          <dl  class="pitch-current">
            <dt class=""><i class="iconfont">&#xe612;</i>职位管理</dt>
            <dd class="current"><a href="#">全部</a></dd>
            <dd class="default-lis"><a href="#">显示中</a></dd>
            <dd class="default-lis"><a href="#">审核中</a></dd>
            <dd class="default-lis"><a href="#">审核未通过</a></dd>
          </dl>
          <dl>
            <dt class="default-title"><i class="iconfont">&#xe60c;</i>简历管理</dt>
            <dd class="default-lis"><a href="#">全部</a></dd>
            <dd class="default-lis"><a href="#">未查看</a></dd>
            <dd class="default-lis"><a href="#">已查看</a></dd>
            <dd class="default-lis"><a href="#">全部</a></dd>
          </dl>
          <dl>
            <dt class="default-title"><i class="iconfont">&#xe60b;</i>用户中心</dt>
            <dd class="default-lis"><a href="#">我的资料</a></dd>
            <dd class="default-lis"><a href="#">我的账号</a></dd>
            <dd class="default-lis"><a href="#">个人认证</a></dd>
            <dd class="default-lis"><a href="#">企业认证</a></dd>
          </dl>
        </div>
      </div>
      <div class="col-sm-12 col-md-10 col-lg-10 padding-0 ">
        <div class="right-center">
          <!--<div class="conter-title">发布兼职职位</div>-->
            <ul class="zhiwei-lis">
            <?php foreach ($tasks as $task) {?>
                <li>
                   <div class="zhiwei-lis-title">
                        <h2 class="pull-left"><?=$task->title?></h2>
                        <div class="pull-left bt-span"><span>刷新</span><span>编辑</span><span>下线</span><span>删除</span></div>
                   </div>
                   <div>
                   <div class="pull-left zhiwei-lis-left">
                       <div><span>200元/日</span><span>月结</span><span>仅限男</span></div>
                       <div>北京－朝阳</div>
                       <div class="fb-sj">发布时间：2015-06-30 10:00</div>
                   </div>
                   <div class="pull-left zhiwei-lis-right">
                        <div>编号：<?=$task->gid?></div>
                        <div class="zhiwei-zt">
                           <div class="pull-left shenqing-zt text-center">已申请：167人</div>
                           <div class="pull-left news text-center">new</div>
                        </div>
                   </div>
                   </div>
                </li>
              <?php }?>
              <!--
                <div class="pagination pagers pull-right pagination-lg">
                      <a href="#">&laquo;</a>
                      <a href="#">1</a>
                      <a href="#">2</a>
                      <a href="#">3</a>
                      <a href="#">4</a>
                      <a href="#">5</a>
                      <a href="#">&raquo;</a>
                </div>
            -->
            <?=LinkPager::widget(['pagination' => $pagination])?>
            </ul>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- InstanceEndEditable -->
