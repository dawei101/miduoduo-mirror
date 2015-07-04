<?php
 
namespace api\modules\v1\controllers;
 
use yii\data\ActiveDataProvider;
use api\modules\BaseActiveController;
use yii\web\ForbiddenHttpException;
 
/**
 * Address Controller API
 *
 * @author dawei
 */
class TaskAddressController extends BaseActiveController
{
    public $modelClass = 'common\models\TaskAddress';


    public $id_column = 'id';
    public $auto_filter_user = false;

    public function actionNearby($lat, $lng, $distance=1000, $service_type_id=null)
    {
        $query = $this->buildBaseQuery();
        $model = $this->modelClass;
        $query = $model::buildNearbyQuery($query, $lat, $lng, $distance);
        return new ActiveDataProvider([
            'query' => $query,
        ]);
    }

}
