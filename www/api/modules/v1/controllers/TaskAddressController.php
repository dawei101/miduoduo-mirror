<?php
 
namespace api\modules\v1\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
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
        $model = $this->modelClass;
        $model::$base_lat = $lat;
        $model::$base_lng = $lng;

        $query = $this->buildFilterQuery();
        $model = $this->modelClass;
        $query = $model::buildNearbyQuery($query, $lat, $lng, $distance);

        $tasks = $query->all();
        usort($tasks, function($a, $b){
            return ($a->distance < $b->distance)?-1:1;
        });
        return new ArrayDataProvider([
            'allModels' => $tasks,
            ]
        );
    }
}
