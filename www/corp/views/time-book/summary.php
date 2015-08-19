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
      <div class="col-sm-2 padding-0">
        <?= $this->render('../layouts/sidebar', ['active_menu'=> 'time_book'])?>
      </div>
      <div class="col-sm-10 padding-0 ">
<div class="right-center">
          <div class="conter-title1">考勤管理 &gt; <?=$task->title?> </div>
<?=$this->render('summary_nav', [
    'subject' => $subject,
    'task' => $task,
])?>
<?= $this->render($subject . '_summary', [
    'task' => $task,
    'models' => $models,
    'pages' => $pages,
]) ?>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- InstanceEndEditable -->
<?php
$this->registerJsFile(Yii::$app->params["baseurl.static.corp"] . '/static/js/task.js');
?>
<?php $this->beginBlock('js') ?>
<script type="text/javascript">
    $(".box_t").on("click","span",function(){
        $(this).parent().parent().find(".kq_box").hide().eq($(this).index()).show()
    });
    $(".kq_box").on("click","span",function(){
        $(this).parent().hide();
    });
    $(".kq_box").on("click","label",function(){
        var i=$(this).index();
        if($(this).index() != 3){
           $(this).parent().parent().find(".ji_nr").hide(); 
        }else{
          $(this).parent().parent().find(".ji_nr").show();  
        }
    });
    
</script> 
<?php $this->endBlock('js') ?>
