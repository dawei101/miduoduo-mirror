<?php
 
namespace api\modules\v1\controllers;
 
use api\modules\BaseActiveController;
use yii\web\ForbiddenHttpException;
use yii\data\ActiveDataProvider;
 
/**
 * District Controller API
 *
 * @author dawei
 */
class DistrictController extends BaseActiveController
{
    public $modelClass = 'common\models\District';

    public function actions()
    {
        $actions = parent::actions();
        return ['index' => $actions['index']];
    }

    public function buildBaseQuery()
    {
        $model = $this->modelClass;
        $query = $model::find()->orderBy('id asc');
        return $query;
    }

    public function prepareDataProvider()
    {
        return new ActiveDataProvider([
            'query' => $this->buildQuery(),
            'pagination' => [
                'pageSize' => 10000
            ],
        ]);
    }


}
