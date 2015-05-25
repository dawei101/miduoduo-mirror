<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Resume */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Resumes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="resume-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('编辑', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '确定删除?',
                'method' => 'post',
            ],
        ]) ?>
        <?php
            if (!$model->isNewRecord)
                echo "<a class='btn btn-primary' href='/freetimes?user_id=" . $model->user_id . "'>编辑空闲时间</a>";
        ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'phonenum',
            'gender',
            'birthdate',
            'degree',
            'nation',
            'height',
            'is_student',
            'college',
            'avatar',
            'gov_id',
            'grade',
            'created_time',
            'updated_time',
            'status',
            'user_id',
            'home',
            'workplace',
        ],
    ]) ?>

</div>
