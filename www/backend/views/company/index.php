<?php

use common\models\Company;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\CompanySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '企业库';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="company-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Company', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'contact_phone',
            'contact_name',
            'contact_email',
            [
                'attribute' => 'status',
                'value' => function($model){
                    return $model->status_label;
                },
                'filter' => Company::$STATUSES,
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
