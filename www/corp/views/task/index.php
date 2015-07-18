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
          <div class="conter-title">职位管理</div>
            <ul class="zhiwei-lis">
            <?php foreach ($tasks as $task) {?>
                <li>
                   <div class="zhiwei-lis-title">
                        <h2 class="pull-left"><a href="<?=Yii::$app->params['baseurl.m']?>/task/view?gid=<?=$task->gid?>" target="blank"><?=$task->title?></a></h2>
                        <div class="pull-left bt-span">
                            <?php if($task->status == 0){?>
                            <span class="task-refresh" gid="<?=$task->gid?>">刷新</span>
                            <span class="task-edit" gid="<?=$task->gid?>">编辑</span>
                            <span class="task-down" gid="<?=$task->gid?>">下线</span>
                            <span class="task-delete" gid="<?=$task->gid?>">删除</span>
                            <?php }else if($task->status == 50){?>
                            <span class="task-edit" gid="<?=$task->gid?>">编辑</span>
                            <?php }?>
                        </div>
                   </div>
                   <div>
                   <div class="pull-left zhiwei-lis-left">
                       <div><span><?=sprintf("%.1f", $task->salary).'元/'.$task->getSalary_unit_label()?></span><span><?=$task->getClearance_period_label()?></span>
                           <span><?=$task->gender_requirement?TASK::$GENDER_REQUIREMENT[$task->gender_requirement]:''?></span></div>
                       <div>北京－朝阳</div>
                       <div class="fb-sj">发布时间：<?=$task->created_time?></div>
                   </div>
                   <div class="pull-left zhiwei-lis-right">
                        <div>编号：<?=$task->gid?></div>
                        <?php if($task->status == 0){?>
                        <div class="zhiwei-zt">
                           <div class="pull-left shenqing-zt text-center">已申请：<?=$task->got_quantity?>人</div>
                           <!--<div class="pull-left news text-center">new</div>-->
                        </div>
                        <?php }else{?>
                           <div class="zhiwei-zt">
                               <div class="bg-left pull-left"></div>
                               <div class="bg-text pull-left text-center"><?=$task->getStatus_label()?></div>
                               <div class="bg-right pull-left"></div>
                           </div>
                        <?php }?>
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
<?php
$this->registerJsFile('/js/task.js');
?>
