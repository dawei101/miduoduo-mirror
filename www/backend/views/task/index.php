<?php
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
                'label' => '是否为优单',
                'format' => 'raw',
                'attribute' => 'recommend',
                'value' => function($model){
                    return $model->getRecommend_label();
                } 
            ],
            'clearance_period_label',
            'salary',
            'salary_unit_label',
            //'status_label',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
