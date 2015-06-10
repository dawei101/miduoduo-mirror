<?php
use common\models\District;
use common\models\ServiceType;

use yii\helpers\Url;


$districts = District::find()->where(['parent_id'=>$city->id])->all();
$service_types = ServiceType::find()->where(['status'=>0])->all();
/* @var $this yii\web\View */
?>

<div class="container">

  <nav class="navbar-fixed-top top-nav" role="navigation">
    <dl class="select">
        <dt style=" white-space: nowrap;"><?=$current_district->name?></dt><span class="inverted-triangle"></span>
        <dd> 
          <ul>
          <li><a href="<?=Url::current(['city'=>$city->id, 'district'=>''])?>">全城</a></li>
<?php foreach($districts as $district) { ?>
    <li><a href="<?=Url::current(['city'=>$city->id, 'district'=>$district->id])?>"><?=$district->name?></a></li>
<?php } ?>
          </ul>
        </dd>
     </dl>
    <dl class="select">
        <dt>类别</dt><span class="inverted-triangle"></span>
        <dd> 
          <ul>
<?php foreach($service_types as $st) { ?>
    <li><a href="<?=Url::current(['service_type'=>$st->id])?>"><?=$st->name?></a></li>
<?php } ?>
          </ul>
        </dd>
     </dl>
     <dl class="select">
        <dt>排序</dt><span class="inverted-triangle"></span>
        <dd> 
          <ul>
            <li><a href="#">默认</a></li>
          </ul>
        </dd>
     </dl>
  </nav>
  <div style="height:50px;"></div>

  <!--===========以上是固定在顶部的==============--> 
<?php foreach ($tasks as $task){ 

?>
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
            <?=$task->city->name?>-<?=$task->district->name?>-<?=$task->address?>
          </p>
          <span class="label label-default train hidden">距我5km</span></div>
      </div>
    </div>
  </div>
</a>
<?php } ?>
<?php $this->beginBlock('js') ?>
<script type="text/javascript">
  $(function(){
    $(".select").each(function(){
      var s=$(this);
      var z=parseInt(s.css("z-index"));
      var dt=$(this).children("dt");
      var dd=$(this).children("dd");
      var _show=function(){dd.slideDown(200);dt.addClass("cur");s.css("z-index",z+1);};   //展开效果
      var _hide=function(){dd.slideUp(200);dt.removeClass("cur");s.css("z-index",z);};    //关闭效果
      dt.on(GB.click_event, function(){dd.is(":hidden")?_show():_hide();});
      dd.find("a").click(function(){dt.html($(this).html());_hide();});     //选择效果（如需要传值，可自定义参数，在此处返回对应的“value”值 ）
      $("body").click(function(i){ !$(i.target).parents(".select").first().is(s) ? _hide():"";});
    });
  });
</script>
<?php $this->endBlock('js') ?>
