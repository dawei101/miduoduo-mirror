<?php
/* @var $this yii\web\View */
$this->title = '首页';
$this->nav_left_link = 'javascript:window.history.back()';
$this->nav_right_link = '/user';
$this->nav_right_title = '个人中心';
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
            ￥<?= floor($task->salary) ?>/<?= $task::$SALARY_UNITS[$task->salary_unit] ?>
           </span> </p>
      </div>
    </div>
    <div class="border-bt">
      <div class="panel-body lnk">
        <p><span class="glyphicon glyphicon-time" aria-hidden="true"></span>
            <?=substr($task->from_date, 5) ?>至<?=substr($task->to_date, 5)?>
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
<script src="/static/js/bxslider.js"></script>
<script>
  $(document).ready(function(){
    $('.bxslider').bxSlider({
    captions: true,//自动控制
          auto: true,
          // speed: 5000,
          pause: 2000,
          infiniteLoop: true,
          controls: false,
          autoHover: false,
  });

    $('.bx-controls').css('position', 'relative');
    $('.bx-default-pager').css('position', 'absolute');
    $('.bx-default-pager').css('top', '-30px');
    $('.bx-default-pager').css('width', '100%');
    //$('.bx-default-pager').css('padding-left', '68%');
});
</script>
<?php $this->endBlock('js') ?>
