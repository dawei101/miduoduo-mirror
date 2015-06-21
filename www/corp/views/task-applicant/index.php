<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TaskApplicantSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Task Applicants';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-applicant-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
             ['attribute'=> 'task_id',
                 'format'=>'raw',
                 'value'=>function($model){
                    if ($model->task){
                        return $model->task->title . "<a target='_blank' class='pull-right' href='/task/view?id=". $model->task_id ."'>查看任务</a>";
                    }
                    return '<span class="pull-right">已删除</span>';
                },
                'label'=>'任务'
             ],
             ['attribute'=> 'user_id',
                 'format'=>'raw',
                 'value'=>function($model){
                    return $model->user->username . "<a target='_blank' class='pull-right' href='/resume/view?user_id=". $model->user_id ."'>查看简历</a>";
                 },
                 'label'=>'用户'
            ],
            'created_time',


        ],
    ]); ?>

</div>
