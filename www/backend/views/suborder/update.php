<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Suborder */

$this->title = 'Update Suborder: ' . ' ' . $model->order_id;
$this->params['breadcrumbs'][] = ['label' => 'Suborders', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->order_id, 'url' => ['view', 'order_id' => $model->order_id, 'address_id' => $model->address_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="suborder-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
