<?php
use common\models\District;
use common\models\ServiceType;
use yii\widgets\LinkPager;

use yii\helpers\Url;

$this->title = '附近兼职';

$this->nav_left_link = 'javascript:window.history.back()';
$this->nav_right_link = '/';
$this->nav_right_title = '首页';
/* @var $this yii\web\View */
?>

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


