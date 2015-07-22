<?php
use yii\helpers\Html;
use yii\grid\GridView;

use common\models\Task;
use common\models\ServiceType;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TaskSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '任务订单';
$this->params['breadcrumbs'][] = $this->title;

$service_type_maps = [];

foreach(ServiceType::findAll(['status'=>0]) as $s){
    $service_type_maps[$s->id] = $s->name;
}
?>
<div class="task-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('创建任务订单', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'gid',
            [
                'label' => '标题',
                'format' => 'raw',
                'attribute' => 'title',
                'value' => function($model){
                    return "<a target='_blank' href='" . \Yii::$app->params['baseurl.m'] . "/task/view/?gid=" . $model->gid ."'>" . $model->title . "</a>";
                }
            ] ,
            [
                'attribute' => 'clearance_period',
                'value' => function ($model){
                    return $model->clearance_period_label;
                },
                'filter' => Task::$CLEARANCE_PERIODS,
            ],
            [
                'attribute' => 'service_type_id',
                'value' => function ($model){
                    return $model->service_type->name;
                },
                'filter' => $service_type_maps,
            ],
            'salary',
            [
                'attribute' => 'salary_unit',
                'value' => function ($model){
                    return $model->salary_unit_label;
                },
                'filter' => Task::$SALARY_UNITS,
            ],
            [
                'attribute' => 'status',
                'value' => function ($model){
                    return $model->status_label;
                },
                'filter' => Task::$STATUSES,
            ],
            'is_overflow_label',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '<div style="min-width:120px">{view_applicant} | {view} {update} {delete} | {adopt} {reject}</div>',
                'buttons' => [
                    'adopt' => function ($url, $model, $key) {
                        if ($model->status==Task::STATUS_IS_CHECK){
                            $options = [
                                'title' => '审核通过',
                                'aria-label' => '审核通过',
                                'data-pjax' => '0',
                                'data-method' => 'post',
                            ];
                            return Html::a('<span class="glyphicon glyphicon-ok"></span>', $url, $options);
                        }
                    },
                    'reject' => function ($url, $model, $key) {
                        if ($model->status==Task::STATUS_IS_CHECK){
                            $options = [
                                'title' => '审核不通过',
                                'aria-label' => '审核不通过',
                                'data-pjax' => '0',
                                'data-method' => 'post',
                            ];
                            return Html::a('<span class="glyphicon glyphicon-remove"></span>', $url, $options);
                        }
                    },
                    'view_applicant' => function ($url, $model, $key) {
                        $url = '/task-applicant?TaskApplicantSearch[task_id]=' . $model->id;
                        $options = [
                            'title' => '查看报名详情',
                            'aria-label' => '查看报名详情',
                        ];
                        return Html::a('<span class="glyphicon glyphicon-list-alt"></span>', $url, $options);
                    }
                ],
            ],
        ],
    ]); ?>

</div>
