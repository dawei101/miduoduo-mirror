<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\jui\DatePicker;
use common\models\TaskApplicant;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TaskApplicantSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '投递管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-applicant-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [      
            ['attribute'=> 'id',
                 'label'=>'投递流水ID'
            ],
            [
                 'attribute'=> 'resume_name',
                 'format'=>'raw',
                 'value'=>function($model){
                     if ($model->resume){
                         return "<a target='_blank' class='pull-right' href='/resume/view?user_id=". $model->user_id ."'>". ($model->resume?($model->resume->name):'') ."</a>";
                     }
                 },
                 'label'=>'简历',
            ],
            [
                'attribute'=> 'resume_phonenum',
                 'format'=>'raw',
                 'value'=>function($model){
                     if ($model->resume){
                        return $model->resume->phonenum;
                     }
                 },
                 'label'=>'报名人电话',
            ],
            ['attribute'=> 'task_title',
                 'format'=>'raw',
                 'value'=>function($model){
                    if ($model->task){
                        return "<a target='_blank' class='pull-right' href='".Yii::$app->params['baseurl.m']."/task/view?gid=". $model->task->gid ."'>".$model->task->title ."</a>";
                    }
                    return '<span class="pull-right">已删除</span>';
                },
                'label'=>'应聘岗位'
            ],
            [
                'label' => '申请日期',
                'attribute' => 'created_time',
                'value' => function($model){
                    return Yii::$app->formatter->asDate($model->created_time);
                },
                'filter' => DatePicker::widget([
                    'name' => 'TaskApplicantSearch[created_time]',
                    'dateFormat' => 'yyyy-MM-dd',
                ]),
            ],
            [
                'attribute' => 'company_alerted',
                'format' => 'boolean',
                'filter' => [0=>'否', 1=>'是']
            ],
            [
                'attribute' => 'applicant_alerted',
                'format' => 'boolean',
                'filter' => [0=>'否', 1=>'是']
            ],
            [
                'attribute' => 'status',
                'value' => function($model){ return $model->status_label;},
                'filter' => TaskApplicant::$STATUSES,
            ],
            ['class' => 'yii\grid\ActionColumn', 'template' => '{update}'],
        ],
    ]); ?>

</div>
