<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Weichat Erweima Logs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="weichat-erweima-log-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <!--p>
        <?= Html::a('Create Weichat Erweima Log', ['create'], ['class' => 'btn btn-success']) ?>
    </p-->

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'erweima_id',
            'openid',
            'create_time',
            // 'has_bind',
            'follow_by_scan',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
