<?php
 
namespace api\modules\v1\controllers;

use Yii;
use yii\data\ArrayDataProvider;
use api\modules\BaseActiveController;
use yii\web\ForbiddenHttpException;
use common\models\Task;
 
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
        $query->joinWith('task')->andWhere(
            [$this->getColumn('status', 'task')=>Task::STATUS_OK]);
        $date_range = Yii::$app->request->get('date_range');
        if ($date_range){
            if ($date_range == 'weekend_only'){
                $query = TaskController::filterWeekendOnly($query);
            } elseif ($date_range == 'next_week'){
                $query = TaskController::filterNextWeek($query);
            } elseif ($date_range == 'current_week'){
                $query = TaskController::filterCurrentWeek($query);
            }
        }
        return $query;
    }

    public function actionNearby($lat, $lng, $distance=5000, $service_type_id=null)
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
