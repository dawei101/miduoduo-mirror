<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\OfflineOrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '线下订单';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="offline-order-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('创建订单', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'gid',
            'plan_quantity',
            'plan_fee',
            ['attribute' => 'need_train', 'value'=>function ($model){
                    return $model->need_train?'是':'否';
                },
             'filter'=>[true=> '是', false=>'否']
            ],
            'company',
            // 'requirement:ntext',
            // 'quality_requirement:ntext',
            // 'status',
            // 'created_by',
            ['attribute'=> 'saleman.name',
             'label'=>'销售人' 
            ],
             ['attribute'=> 'suborder',
             'format'=>'raw',
             'value'=>function($model){
                return "<a class='btn btn-success' href='/suborder?order_id=". $model->id ."'>编辑</a>";
             },
             'label'=>'子订单'
            ],


            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
