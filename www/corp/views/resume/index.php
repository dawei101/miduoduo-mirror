<?php

use yii\helpers\Html;
use yii\grid\GridView;

use common\models\Resume;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ResumeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '简历';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="resume-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('创建简历', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            'phonenum',
            ['attribute' => 'gender', 'value'=>
                function ($model){
                    return Resume::$GENDERS[$model->gender];
                },
            'filter'=>Resume::$GENDERS
            ],
            ['attribute' => 'is_student', 'value'=>function ($model){
                    return $model->is_student?'是':'否';
                },
            'filter'=>[true=> '是', false=>'否']
            ],
            'college',
            'gov_id',
            ['attribute' => 'status', 'value'=>
                function ($model){
                    return Resume::$STATUS_LABELS[$model->status];
                },
            'filter'=>Resume::$STATUS_LABELS
            ],


            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>