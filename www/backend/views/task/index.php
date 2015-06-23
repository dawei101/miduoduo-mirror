<?php
header('content-type:text/html;charset=utf-8');
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TaskSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '任务订单';
$this->params['breadcrumbs'][] = $this->title;
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
            'id',
            [
                'label' => '标题',
                'format' => 'raw',
                'value' => function($model){
                    //var_dump($model);die();
                    return "<a target='_blank' href='" . \Yii::$app->params['baseurl.m'] . "/task/view/?gid=" . $model->gid ."'>" . $model->title . "</a>";
                }
            ]
            ,
             [
                //'attribute' => 'state',
                'label'=>'结算方式',
                'value'=>
                function($model){
                    return $model::$CLEARANCE_PERIODS[$model->clearance_period];
                },
            ],
            'salary',
            'salary_unit',
           
            // 'salary_note:ntext',
            // 'from_date',
            // 'to_date',
            // 'from_time',
            // 'to_time',
            // 'need_quantity',
            // 'got_quantity',
            // 'created_time',
            // 'updated_time',
            // 'detail:ntext',
            // 'requirement:ntext',
            // 'address_id',
            // 'user_id',
            // 'service_type_id',
            // 'gender_requirement',
            // 'degree_requirement',
            // 'age_requirement',
            // 'height_requirement',
            // 'status',
            // 'city_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
