<?php
/* @var $this yii\web\View */
$this->title = '米多多首页';

?>

<div class="midd-logo-top">
    <div class="logo">
        <img src="/static/img/logo.png" class="img-responsive">
    </div>
    <a href="/user/login" class="btn btn-green btn-lg btn-block">登录</a>
    <a href="/user/vlogin" class="btn btn-white btn-lg btn-block">注册</a>
</div>
<div id="content"> 
  <div class="recommend"><caption>热门推荐</caption></div>

<?php foreach ($tasks as $task){ ?>
<a href="/task/view?gid=<?=$task->gid?>" class="list-group-item">
  <div class="panel panel-default zhiwei-list"> 
    <div class="border-bt">
        <div class="panel-heading">
            <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>
            <h3 class="panel-title"><?=$task->title ?></h3>
        </div>
      <div class="panel-body list-bt">
        <p> <span class="label label-default">
            ￥<?= $task->salary ?>/<?= $task::$SALARY_UNITS[$task->salary_unit] ?>
           </span> </p>
      </div>
    </div>
    <div class="border-bt">
      <div class="panel-body lnk">
        <p><span class="glyphicon glyphicon-time" aria-hidden="true"></span>
            <?=$task->from_date ?>至<?=$task->to_date?>
            <?=$task->from_time ?> - <?=$task->to_time ?>
        </p>
        <div class="te-x">
          <p><span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span>
            <?=$task->address->city?>-<?=$task->address->address?>
          </p>
          <span class="label label-default train hidden">距我5km</span></div>
      </div>
    </div>
  </div>
</a>
<?php } ?>


  </div>
</div>
