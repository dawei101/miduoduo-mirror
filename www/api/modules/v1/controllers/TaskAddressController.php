<?php
 
namespace api\modules\v1\controllers;

use Yii;
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

    public function beforeAction($action)
    {
        if ($action->id == 'nearby'){
            $_GET['expand'] = 
                isset($_GET['expand'])?($_GET['expand'] . ',task'):'task';
        }
        return parent::beforeAction($action);
    }

    public function buildFilterQuery()
    {
        $query = parent::buildFilterQuery();
        $date_range = Yii::$app->request->get('date_range');
        if ($date_range){
            $query->joinWith('task');
            if ($date_range == 'weekend_only'){
                $query = static::filterWeekendOnly($query);
            } elseif ($date_range == 'next_week'){
                $query = static::filterNextWeek($query);
            } elseif ($date_range == 'current_week'){
                $query = static::filterCurrentWeek($query);
            }
        }
        return $query;
    }

    public function actionNearby($lat, $lng, $distance=1000, $service_type_id=null)
    {
        $model = $this->modelClass;
        $model::$base_lat = $lat;
        $model::$base_lng = $lng;

        $query = $this->buildFilterQuery();
        $model = $this->modelClass;
        $query = $model::buildNearbyQuery($query, $lat, $lng, $distance);

        return new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes'=> ['distance', 'id']
            ],
        ]);
    }
}
