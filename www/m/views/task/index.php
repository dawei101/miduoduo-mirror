<?php
use common\models\District;
use common\models\ServiceType;
use yii\widgets\LinkPager;

use yii\helpers\Url;

$this->title = ($current_service_type?$current_service_type->name:'') . '兼职列表';


$districts = District::find()->where(['parent_id'=>$city->id])->all();
$service_types = ServiceType::find()->where(['status'=>0])->all();


$this->nav_left_link = 'javascript:window.history.back()';
$this->nav_right_link = '/';
$this->nav_right_title = '首页';
/* @var $this yii\web\View */
?>

  <nav class="navbar-fixed-top top-nav" style="top: 50px;" role="navigation">
    <dl class="select">
        <dt style=" white-space: nowrap;"><?=$current_district->name?> <span class="caret"></span>
</dt><span class="inverted-triangle"></span>
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
        <dt><?=$current_service_type?$current_service_type->name:'全部'?><span class="caret"></span> </dt>
        <dd> 
          <ul>
    <li><a href="<?=Url::current(['service_type'=>''])?>">全部</a></li>
<?php foreach($service_types as $st) { ?>
    <li><a href="<?=Url::current(['service_type'=>$st->id])?>"><?=$st->name?></a></li>
<?php } ?>
          </ul>
        </dd>
     </dl>
     <dl class="select">
        <dt>排序 <span class="caret"></span> </dt>
        <dd> 
          <ul>
            <li><a href="#">默认</a></li>
          </ul>
        </dd>
     </dl>
  </nav>
  <div style="height:50px;"></div>
<?=
  $this->render('@m/views/task/task-list.php', [
        'tasks' => $tasks,
        'pages' => $pages
    ]);
?>


  <!--===========以上是固定在顶部的==============--> 
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


