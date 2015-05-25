<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\OfflineOrder */

$this->title = "订单:" . $model->gid;
$this->params['breadcrumbs'][] = ['label' => 'Offline Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="offline-order-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('更新', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '确定删除?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'gid',
            'date',
            'worker_quntity',
            [
                'attribute'=> 'worker_dispatch_summary',
                'label'=> '派遣情况',
                'format' => 'raw',
                'value'=>Html::a('委派', ['dispatch', 'id' => $model->id], ['class' => 'btn btn-primary pull-right'])
            ],
            'fee',
            'need_train',
            'requirement:ntext',
            'quality_requirement:ntext',
            'status',
            'created_by',
            'pm_id',
            'saleman_id',
            'company',
            'person_fee',
        ],
    ]) ?>

</div>
