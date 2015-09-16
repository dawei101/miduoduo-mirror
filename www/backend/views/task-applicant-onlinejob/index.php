<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\TaskApplicantOnlinejob;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TaskApplicantOnlinejobSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Task Applicant Onlinejobs');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-applicant-onlinejob-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <!--p>
        <?= Html::a(Yii::t('app', 'Create Task Applicant Onlinejob'), ['create'], ['class' => 'btn btn-success']) ?>
    </p-->

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            //'id',
            'user_id',
            [
                'label' => '审核状态',
                'attribute' => 'status',
                'filter' => TaskApplicantOnlinejob::$STATUS,
                'value' => function($model){
                    return TaskApplicantOnlinejob::$STATUS[$model->status];
                }
            ],
            'reason',
            //'app_id',
            
             'task_id',
            // 'needinfo:ntext',
            // 'has_sync_wechat_pic',
            'need_phonenum',
            'need_username',
            // 'need_person_idcard',
            'created_time',
            // 'updated_time',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
