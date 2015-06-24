<?php

use yii\helpers\Html;
use yii\grid\GridView;

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
                 'format'=>'raw',
                 'label'=>'投递流水ID'
            ],
            ['attribute'=> 'xxxxxxxxxxxxxxxxx',
                 'format'=>'raw',
                 'value'=>function($model){
 //var_dump($model->resume->name);die();
                    // return $model->user->username . "<a target='_blank' class='pull-right' href='/resume/view?user_id=". $model->user_id ."'>查看简历</a>";
                     return "<a target='_blank' class='pull-right' href='/resume/view?user_id=". $model->user_id ."'>".$model->resume->name."</a>";

                 },
                 'label'=>'简历',
            ],
            ['attribute'=> 'xxxxxxxxxxxxxxxxx',
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
             'attribute' => 'xxxxxxxxxxxxxxxxx',
             'format' => 'raw',
             'label' => '联系方式',
             'value' => function($model){
                return $model -> user -> username;
             },

            ],
            [
                'attribute' => 'xxxxxxxxxxxxxxxxx',
                'format' => 'raw',
                'label' => '投递时间',
                'value' => function($model){
                    if($model -> created_time){
                        return substr($model -> created_time, 2,14);
                    }
                    return '<span class="pull-right">已删除</span>';
                },
            ],
        ],
    ]); ?>

</div>
