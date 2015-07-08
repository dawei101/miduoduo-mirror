<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\WeichatUserInfo */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Weichat User Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="weichat-user-info-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'openid',
            'userid',
            'status',
            'created_time',
            'updated_time',
            'weichat_name',
            'weichat_head_pic',
            [   
                'attribute' => 'is_receive_nearby_msg',
                'value'=>$model->is_receive_nearby_msg ? '是' : '否',
            ],
        ],
    ]) ?>

</div>
