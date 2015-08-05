<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use common\models\WithdrawCash;

/* @var $this yii\web\View */
/* @var $searchModel common\models\WithdrawCashSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '提现管理');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="withdraw-cash-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', '导出提现信息'), Url::current(['action'=>'download']), ['class' => 'btn btn-success','target'=>'_blank']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'id',
            'user_id',
            [
                'label' => '姓名',
                'value' => function($model){
                    return $model->userinfo->name;
                }
            ],
            [
                'label' => '手机号',
                'value' => function($model){
                    return $model->userinfo->phonenum;
                }
            ],
            [
                'label' => '绑定银行卡/微信账号',
                'value' => function($model){
                    return $model->payout->account_id;
                }
            ],
            [
                'label' => '开户行',
                'value' => function($model){
                    return $model->payout->account_info;
                }
            ],
            'value',
            'withdraw_time',
            'updated_time',
            //'type',
            // 'payout_id',
            [
                'filter'=> WithdrawCash::$STATUS,
                'label' => '提现状态',
                'attribute'    => 'status',
                'value' => function($model){
                    return $model->status_label;
                }
            ],
            [
                'label' => '处理结果',
                'value' => function($model){
                    return $model->payout->status;
                }
            ],
            [
                'label' => '操作人',
                'value' => function($model){
                    return $model->operatorinfo->name;
                }
            ],
            // 'updated_time',
            // 'note:ntext',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
