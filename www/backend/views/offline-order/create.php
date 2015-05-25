<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\OfflineOrder */

$this->title = '创建订单';
$this->params['breadcrumbs'][] = ['label' => 'Offline Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="offline-order-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
