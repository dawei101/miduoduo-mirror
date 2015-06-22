<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Tinyorder */

$this->title = 'Create Tinyorder';
$this->params['breadcrumbs'][] = ['label' => 'Tinyorders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tinyorder-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
