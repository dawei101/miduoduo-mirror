<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\WeichatUserInfo */

$this->title = '更新用户微信信息: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Weichat User Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="weichat-user-info-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
