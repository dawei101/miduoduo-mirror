<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\jui\DatePicker;

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
            ['attribute'=> 'resume',
                 'format'=>'raw',
                 'value'=>function($model){
 //var_dump($model->resume->name);die();
                    // return $model->user->username . "<a target='_blank' class='pull-right' href='/resume/view?user_id=". $model->user_id ."'>查看简历</a>";
                     return "<a target='_blank' class='pull-right' href='/resume/view?user_id=". $model->user_id ."'>". ($model->resume?($model->resume->name):'') ."</a>";

                 },
                 'label'=>'简历',
            ],
            ['attribute'=> 'task',
                 'format'=>'raw',
                 'value'=>function($model){
                    if ($model->task){
                        return "<a target='_blank' class='pull-right' href='/task/view?id=". $model->task_id ."'>".$model->task->title ."</a>";
                    }
                    return '<span class="pull-right">已删除</span>';
                },
                'label'=>'应聘岗位'
            ],
            [
             'attribute' => 'contact',
             'label' => '联系方式',
             'value' => function($model){
                return $model->user->username;
             },
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
            'company_alerted:boolean',
            'applicant_alerted:boolean',
            'status_label',
            ['class' => 'yii\grid\ActionColumn', 'template' => '{update}'],
        ],
    ]); ?>

</div>
