<?php

use common\models\TaskApplicant;


$this->title = '职位详情';

$this->nav_left_link = 'javascript:window.history.back()';
$this->nav_right_link = '/';
$this->nav_right_title = '首页';

?>
<div class="panel panel-default">
    <div class="panel-heading">
    <h2><?= $task->title ?></h2>
    </div>
    <div class="panel-body list-bt">
        <p>
            <span class="label label-default">￥<?= $task->salary ?>/<?= $task::$SALARY_UNITS[$task->salary_unit] ?></span>
        </p>
    </div>
</div>

<div class="panel panel-default">
  <div class="border-bt">
    <div class="panel-heading">
      <h3 class="panel-title">工作时间</h3>
    </div>
    <div class="panel-body">
      <p><?=$task->from_date ?>至<?=$task->to_date?>
        <?=$task->from_time ?> - <?=$task->to_time ?>
      </p>
    </div>
  </div>
  <div class="border-bt">
    <div class="panel-heading">
      <h3 class="panel-title">工作地点</h3>
    </div>
    <div class="panel-body">
      <p><?=$task->address ?></p>
      <div class="ki hidden"><span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span></div>
      <p style="display:none;">距我5km</p>
    </div>
  </div>
</div>

<div class="panel panel-default">
  <div class="border-bt">
    <div class="panel-heading">
      <h3 class="panel-title">公司名称</h3>
    </div>
    <div class="panel-body">
      <p><?=$task->company_name?></p>
    </div>
  </div>
  <div class="border-bt">
    <div class="panel-heading">
      <h3 class="panel-title">联系人</h3>
    </div>
    <div class="panel-body">
      <p><?=$task->contact?></p>
    </div>
  </div>
  <div class="border-bt">
    <div class="panel-heading">
      <h3 class="panel-title">联系电话</h3>
    </div>
    <div class="panel-body">
      <p><?=$task->contact_phonenum?></p>
    </div>
  </div>


</div>

<div class="panel panel-default">
  <div class="border-bt">
    <div class="panel-heading">
      <h3 class="panel-title">工作内容</h3>
    </div>
    <div class="panel-body pan-bot">
      <p> <?=htmlentities($task->detail) ?></p>
    </div>
  </div>
</div>

<nav class="navbar navbar-default navbar-fixed-bottom nav-bg" role="navigation">
<?php
    $applied = !Yii::$app->user->isGuest && TaskApplicant::isApplied(Yii::$app->user->id, $task->id);
    $ended = $task->to_date<date('Y-m-d');
?>
  <button id="apply" style="width: 100%;" type="button" class="btn btn-primary btn-lg btn-block"><?= $applied?'已报名':($ended?'报名结束':'报名') ?></button>
  <div class="store-sc hidden" id="collect"><span class="glyphicon glyphicon-heart"></span><br>收藏</div>
  <a href="/task/report?gid=<?=$task->gid?>" class="report-jb hidden" id="report">
     <span class="glyphicon glyphicon-eye-open"></span><br>举报
  </a >
</nav>

<?php $this->beginBlock('js') ?>
<?php 
if (!$ended &&!$applied){
?>
<script>
$(function(){
    $("#apply").bind(GB.click_event, function(){
        window.location.href= '/task/apply?gid=<?=$task->gid?>';
    });
});
</script>
<?php
}
?>
<?php $this->endBlock('js') ?>
