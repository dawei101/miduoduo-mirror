<?php
 
namespace api\modules\v1\controllers;

use Yii;
use api\modules\BaseActiveController;
use common\Utils;
use common\models\Task;
 
/**
 * Address Controller API
 *
 * @author dawei
 */
class TaskController extends BaseActiveController
{
    public $modelClass = 'common\models\Task';

    public $id_column = 'id';

    public function actions()
    {
        $actions = parent::actions();
        return ['index'=> $actions['index'], 'view'=> $actions['view']];
    }

    public function buildBaseQuery()
    {
        $model = $this->modelClass;
        $query = parent::buildBaseQuery();
        $query->andWhere(['status'=>$model::STATUS_OK]);
        return $query;
    }

    public function buildFilterQuery()
    {
        $query = parent::buildFilterQuery();
        $date_range = Yii::$app->request->get('date_range');
        if ($date_range == 'weekend_only'){
            $query = static::filterWeekendOnly($query);
        } elseif ($date_range == 'next_week'){
            $query = static::filterNextWeek($query);
        } elseif ($date_range == 'current_week'){
            $query = static::filterCurrentWeek($query);
        }
        return $query;
    }

    public static function filterNextWeek($query)
    {
        $from_date = Task::tableName() . '.from_date';
        $to_date = Task::tableName() . '.to_date';
        $f_date = strtotime('monday');
        if (date('w', time())==1) {
            $f_date = strtotime('+2 monday');
        }
        $t_date = strtotime('sunday', $f_date);
        $query->andWhere(['and', 
                ['>=', $to_date, date('Y-m-d', $f_date)],
                ['<=', $from_date, date('Y-m-d', $t_date)]]);
        return $query;
    }

    public static function filterCurrentWeek($query)
    {
        $from_date = Task::tableName() . '.from_date';
        $to_date = Task::tableName() . '.to_date';
        $t_date = strtotime('sunday');
        $f_date = strtotime('-1 monday', $t_date);
        $query->andWhere(['and', 
                ['>=', $to_date, date('Y-m-d', $f_date)],
                ['<=', $from_date, date('Y-m-d', $t_date)]]);
        return $query;
    }

    public static function filterWeekendOnly($query)
    {
        $from_date = Task::tableName() . '.from_date';
        $to_date = Task::tableName() . '.to_date';
        $day_batch = [];
        $sat = strtotime('saturday');
        if (date('w', time())==0){
            $sat = strtotime('-1 saturday');
        } else {
            $sat = strtotime('saturday');
        }
        $day_batch = [
            [date('Y-m-d', strtotime('saturday', $sat)),
                date('Y-m-d', strtotime('sunday', $sat))],
            [date('Y-m-d', strtotime('+2 saturday', $sat)),
                date('Y-m-d', strtotime('+2 sunday', $sat))],
            [date('Y-m-d', strtotime('+3 saturday', $sat)),
                date('Y-m-d', strtotime('+3 sunday', $sat))],
            [date('Y-m-d', strtotime('+4 saturday', $sat)),
                date('Y-m-d', strtotime('+4 sunday', $sat))],
        ];
        $where = '1=0 ';

        foreach ($day_batch as $day_range){
            $where .= 
                " or ( $to_date >= '$day_range[0]' and $from_date <= '$day_range[1]')";
        }
        $query->andWhere($where);
        return $query;
    }

}
