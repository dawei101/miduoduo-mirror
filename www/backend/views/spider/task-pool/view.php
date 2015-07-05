<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\TaskPool */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Task Pools', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-pool-view">

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
            'company_name',
            'city',
            'origin_id',
            'origin',
            'lng',
            'lat',
            'details:ntext',
            'has_poi',
            'has_imported',
            'created_time',
        ],
    ]) ?>

</div>
