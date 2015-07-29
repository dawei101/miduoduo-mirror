<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\console\Application;
use yii\helpers\ArrayHelper;

class JobWorkerController extends Controller
{

    public $defaultAction = 'run';

    public function actionRun()
    {
        $app = Yii::$app;
        while (1) {
            $jobs = Yii::$app->job_queue_manager->get();
            if (count($jobs)==0){
                echo "No job found, sleep 30s\n";
                sleep(30);
            }
            foreach ($jobs as $job){
                $route = $job->task_name;
                $params = $job->unserializeParmas;
                $r = false;
                try {
                    if ($app->runAction($route, $params)) {
                        $job->status = $job::STATUS_DONE;
                        $job->save();
                        $r = true;
                    } else {
                        $job->message = "未知的失败原因";
                    }
                } catch (Exception $e){
                    $job->message = $e->getMessage();
                }

                if (!$r){
                    $job->status = $job::STATUS_FAILED;
                    $job->retryIfCan();
                    $job->save();
                }
            }
        }
    }
}
