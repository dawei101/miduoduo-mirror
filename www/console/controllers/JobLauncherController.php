<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\console\Application;
use yii\helpers\ArrayHelper;

class JobLauncherController extends Controller
{

    public $defaultAction = 'launch';

    public function actionLaunch()
    {
        $app = Yii::$app;
        while (1) {
            $tasks = Yii::$app->task_queue_manager->get();
            if (count($tasks)==0){
                break;
            }
            foreach ($tasks as $task){
                $route = $task->task_name;
                $params = $task->unserializeParmas;
                try {
                    $app->runAction($route, $params);
                } catch (Exception $e){
                    
                }
            }
        }
    }
}
