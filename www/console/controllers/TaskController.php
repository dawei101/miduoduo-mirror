<?php
/**
 */

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\console\Exception;
use \common\models\Task;

/**
 */

class TaskController extends Controller
{
    public function actionOffline(){
        $now = date("Y-m-d H:i:s");
        $count = Task::updateAll(['status'=>Task::STATUS_OFFLINE],
            'to_date < :to_date and status=:status' , 
            ['to_date' => $now, 'status' => Task::STATUS_OK]
        );
        echo "Task Status:: $count tasks are changed to offline\n";
        Yii::info("Task Status:: $count tasks are changed to offline");
    }
}

