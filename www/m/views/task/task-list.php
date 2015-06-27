<?php 
use yii\widgets\LinkPager;

?>

<?php foreach ($tasks as $task){ ?>
<a href="/task/view?gid=<?=$task->gid?>" class="list-group-item">
  <div class="panel panel-default zhiwei-list"> 
    <div class="border-bt">
        <div class="panel-heading">
            <h3 class="panel-title"><?=$task->title ?></h3>
        </div>
      <div class="panel-body list-bt">
        <p> <span class="label label-default">
            ￥<?=floor($task->salary) ?>/<?= $task::$SALARY_UNITS[$task->salary_unit] ?>
           </span> </p>
      </div>
    </div>
    <div class="border-bt">
      <div class="panel-body lnk">
        <p><span class="glyphicon glyphicon-time" aria-hidden="true"></span>
            <?=\Yii::$app->formatter->asDate($task->from_date);?>至<?=\Yii::$app->formatter->asDate($task->to_date)?>
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
<div class="text-center" style="width: 100%;" >
<?=LinkPager::widget(['pagination' => $pages,
    'maxButtonCount'=>0,
    'lastPageLabel'=>'末页', 'nextPageLabel'=>'下一页',
    'prevPageLabel'=>'上一页', 'firstPageLabel'=>'首页'])?>
</div>
