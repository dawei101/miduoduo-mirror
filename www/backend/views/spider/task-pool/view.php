<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\TaskPool */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Task Pools', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-pool-view">

    <h1>爬虫记录详情：<?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'company_name',
            'city',
            'origin_id',
            'origin',
            'lng',
            'lat',
            'has_poi:boolean',
            'created_time',
        ],
    ]) ?>
    <h2>详情<a class="pull-right" target="_blank" href="<?=$model->origin_url?>">来源页</a></h2>
<table class="table table-striped table-bordered detail-view">
    <tbody>
      <?php foreach($model->list_detail() as $attr=>$value) { ?>
      <tr><th><?=$attr?></th><td><?=$value?></td></tr>
      <?php } ?>
    </tbody>
</table> 



</div>
