<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\TaskPoolSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Task Pools';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-pool-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Task Pool', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'company_name',
            'city',
            'origin_id',
            'origin',
            // 'lng',
            // 'lat',
            // 'details:ntext',
            // 'has_poi',
            // 'has_imported',
            // 'created_time',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
