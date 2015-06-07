<?php

use common\models\TaskApplicant;


?>
<div class="panel panel-default">
    <div class="panel-heading">
    <h2><?= $task->title ?></h2>
    </div>
    <div class="panel-body">
        <p>
            <span class="label label-default">￥<?= $task->salary ?><i>/<?= $task::$SALARY_UNITS[$task->salary_unit] ?></i></span>
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
    <table class="table">
      <tr>
        <td class=""><div class="panel-heading">
            <h3 class="panel-title">工作地点</h3>
          </div>
          <div class="panel-body">
            <p><?=$task->address->address ?></p>
          </div></td>
        <td class="map-jl col-lg-1">
          <div class="ki"><span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span></div>
          <p style="display:none;">距我5km</p>
        </td>
      </tr>
    </table>
  </div>
</div>

<div class="panel panel-default">
  <div class="table-box">
    <table class="table">
      <tr>
        <td class="col-l"><h3 class="panel-title">公司</h3></td>
        <td><div class="panel-body">
            <p><?=$task->company->name?></p>
          </div></td>
      </tr>
    </table>
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
    $ended = $task->to_date < time();
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
