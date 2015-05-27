<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Suborder */

$this->title = '添加子订单for:' . $order->gid;
$this->params['breadcrumbs'][] = ['label' => 'Suborders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="suborder-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
