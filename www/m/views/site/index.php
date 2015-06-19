<?php
/* @var $this yii\web\View */
$this->title = '首页';

$this->params['nav_right'] = null;
// nav_right nav_left 结构 ['title'=>'首页', 'link'=>'/'];
$this->params['nav_left'] = null;

?>



<?php $this->beginBlock('css') ?>
<style>
  /*================首页图片滚动===============*/
.bxslider{width:100%;}
.bxslider img{width:100%;}
.bx-wrapper .bx-pager {text-align: center;font-size: .85em;font-family: Arial;font-weight: bold;color: #666;}
.bx-wrapper .bx-pager .bx-pager-item,.bx-wrapper .bx-controls-auto .bx-controls-auto-item {display: inline-block;*zoom: 1;*display: inline;}
.bx-wrapper .bx-pager.bx-default-pager a {background: #ff694e;text-indent: -9999px;display: block;width: 10px;height: 10px;margin: 0 5px;outline: 0;-moz-border-radius: 5px;-webkit-border-radius: 5px;border-radius: 5px;}
.bx-wrapper .bx-pager.bx-default-pager a:hover,.bx-wrapper .bx-pager.bx-default-pager a.active {background: #fff;}
</style>
<?php $this->endBlock('css') ?>



<ul class="bxslider">
      <li><a href="/hongbao.html"><img src="/static/img/hongbao.png" ></a></li>
      <li><a href="/user/vsignup"><img src="/static/img/zhuce.png" ></a></li>
</ul>
<!-- <div class="midd-logo-top">
    <div class="logo">
        <img src="/static/img/logo.png" class="img-responsive">
        <p style="text-align:center; font-size:12px; color:#584a33;">
        不　　仅　　仅　　是　　兼　　职
        </p>
    </div>
    <?php //if (\Yii::$app->user->isGuest){ ?>
    <a href="/user/login" class="btn btn-green btn-lg btn-block">登录</a>
    <a href="/user/vsignup" class="btn btn-white btn-lg btn-block">注册</a>
    <?php //}?>
    <p class="text-center"> <a style="background:#f23f28;color: #fff;" href="/hongbao.html" class="btn btn-white btn-lg btn-block">抢红包</a> </p>
</div> -->
<div id="content"> 
  <div class="recommend"><caption>热门推荐</caption></div>

<?php foreach ($tasks as $task){ ?>
<a href="/task/view?gid=<?=$task->gid?>" class="list-group-item">
  <div class="panel panel-default zhiwei-list"> 
    <div class="border-bt">
        <div class="panel-heading">
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
            <?=$task->city->name?>-<?=$task->district->name?>-<?=$task->address?>
          </p>
          <span class="label label-default train hidden">距我5km</span></div>
      </div>
    </div>
  </div>
</a>
<?php } ?>
<a href="/task" style="color:#ffa005; display:block; padding:10px 0 15px; text-align:center; margin:0 auto;font-size:1.3em;">更多职位&nbsp;>></a>

  </div>
</div>

<?php $this->beginBlock('js') ?>
<!-- <script src="static/js/jquery.min.js"></script> -->
<script src="static/js/bxslider.js"></script>
<script src="static/js/inedex_banner.js"></script>
<?php $this->endBlock('js') ?>