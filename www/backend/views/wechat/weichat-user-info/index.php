<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '微信推送-绑定用户';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="weichat-user-info-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <!--p>
        <?= Html::a('Create Weichat User Info', ['create'], ['class' => 'btn btn-success']) ?>
    </p-->

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'openid',
            'userid',
            //'status',
            'created_time',
            // 'updated_time',
            // 'weichat_name',
            // 'weichat_head_pic',
            //'is_receive_nearby_msg',
            [
                'label' => '是否接受微信推送',
                'format'=> 'raw',
                'value' => function($model){
                    if( $model->is_receive_nearby_msg == 1 ){
                        return '是';
                    }else{
                        return '否';
                    } 
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
