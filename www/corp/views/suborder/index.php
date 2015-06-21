<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SuborderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = '子订单for订单号:' . $order->gid;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="suborder-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
        <?= Html::a('添加子订单', ['create', 'order_id'=>$order->id], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'address_id',
            'date',
            'from_time',
            'to_time',
            'quantity',
            'got_qunatity',
             ['attribute'=> 'suborder',
             'format'=>'raw',
             'value'=>function($model){
                return "<a class='btn btn-success' href='/suborder?order_id=". $model->id ."'>设置人员</a>";
             },
             'label'=>'设置人员'
            ],

            // 'modified_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
