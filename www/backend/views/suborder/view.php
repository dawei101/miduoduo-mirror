<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Suborder */

$this->title = $model->order_id;
$this->params['breadcrumbs'][] = ['label' => 'Suborders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="suborder-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'order_id' => $model->order_id, 'address_id' => $model->address_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'order_id' => $model->order_id, 'address_id' => $model->address_id], [
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
            'order_id',
            'address_id',
            'from_time',
            'to_time',
            'quantity',
            'got_qunatity',
            'modified_by',
        ],
    ]) ?>

</div>
