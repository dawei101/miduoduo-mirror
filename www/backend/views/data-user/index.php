<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '数据-用户端';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="data-daily-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <!--?= Html::a('Create Data Daily', ['create'], ['class' => 'btn btn-success']) ?-->
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'type',
            'date',
            'key',
            'value',
            // 'create_time',
            // 'update_time',
            // 'city_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
