<?php
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TaskSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '待带审核列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,//过滤模型
        'columns' => [
            'gid',
            [
                'label' => '标题',
                'format' => 'raw',
                'value' => function($model){
                    return "<a target='_blank' href='" . \Yii::$app->params['baseurl.m'] . "/task/view/?gid=" . $model->gid ."'>" . $model->title . "</a>";
                } 
            ] ,
            'status_label',
            [
                'label'=>'操作',
                'format'=>'raw',
                'value' => function($model){
                    $furl = "/task/passed/?id=" . $model->id."&status=40";
                    $surl = "/task/passed/?id=" . $model->id."&status=0";
                    return Html::a('通过审核', $surl) .'|'. Html::a('未通过审核', $furl) ; 
                }
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
