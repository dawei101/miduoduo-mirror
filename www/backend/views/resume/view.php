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
                echo "<a class='btn btn-primary' href='/resume/freetimes?user_id=" . $model->user_id . "'>编辑空闲时间</a>";
        ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute'=> 'user',
                'label'=> '账号',
                'format'=>'raw',
                'value'=>"<a target='_blank' href='/user/view?id=".$model->user_id."'>点击查看</a>"
            ],
            'name',
            'phonenum',
            'gender',
            [
                'attribute'=> 'gender',
                'label'=> '性别',
                'value'=>$model::$GENDERS[$model->gender]
            ],
            [   'attribute' => 'is_student',
                'value'=>$model->is_student?'是':'否',
            ],
            [   'attribute' => 'grade',
                'value'=>$model::$GRADES[$model->grade]
            ],
            'birthdate',
 
 
            'birthdate',
            'degree',
            'nation',
            'height',
            'college',
            'avatar',
            'gov_id',
            'created_time',
            'updated_time',
            'birthdate',
            'home',
            'workplace',
            [   'attribute' => 'status',
                'value'=>$model::$STATUS_LABELS[$model->status]
            ],
        ],
    ]) ?>

</div>
