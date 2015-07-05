<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\TaskPoolSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Task Pools';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-pool-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Task Pool', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'label'=> '#',
                'format'=> 'raw',
                'value' => function($model){
                    return '<a href="/task-pool/view?id=' . $model->id . '" title="查看" target="_blank">
                                <span class="glyphicon glyphicon-eye-open"></span> 
                            ' . $model->id . '
                            </a> ';
                },
            ],
            'company_name',
            'city',
            [
                'label' => '来源',
                'format' => 'raw',
                'value' => function($model){
                    return $model->origin.'<br /> <a href="' . $model->origin_url . '" title="查看愿帖子" target="_blank">
                            <span class="glyphicon glyphicon-eye-open"></span> </a> ';
                },
            ] ,

            // 'lng',
            // 'lat',
            // 'details:ntext',
            'has_poi:boolean',
            // 'has_imported',
            // 'created_time',
            'status_label',
            [
                'label' => '操作',
                'format'=>'raw',
                'value'=> function($model){
                    return '
                        <a target="_blank" href="/index.php/task-pool/transfer?id='.$model->id.'" title="添加到米多多" data-method="post">
                             <span class="glyphicon glyphicon-export"></span>
                        </a>
                        <a target="_blank" style="color: red;" href="/index.php/task-pool/transfer?company_name='. $model->company_name .'" title="将公司加入白名单" >
                            <span class="glyphicon glyphicon-export"></span>
                        </a>
                        <a href="/index.php/task-pool/delete?id='. $model->id .'" title="删除记录" aria-label="删除" data-confirm="您确定要删除此项吗？" data-method="post">
                            <span class="glyphicon glyphicon-remove"></span>
                        </a>
                        <a style="color: red;"  href="/index.php/task-pool/delete?company_name='. $model->company_name .'" aria-label="删除" data-confirm="您确定要把此公司加入黑名单吗？" data-method="post" title="删除公司并列入黑名单">
                            <span class="glyphicon glyphicon-lock"></span>
                        </a>
                        ';
                }
            ],
        ],
    ]); ?>

</div>
