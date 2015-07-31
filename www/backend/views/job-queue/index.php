<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\JobQueueSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Job Queues';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="job-queue-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Job Queue', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'task_name',
            'params',
            'retry_times:datetime',
            'start_time',
            // 'priority',
            // 'status',
            // 'message:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
