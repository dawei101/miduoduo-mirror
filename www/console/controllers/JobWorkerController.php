<?php
namespace console\controllers;

use Exception;

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
                $this->runJob($job);
            }
        }
    }

    public function camelcase($w)
    {
        $ss = explode('-', $w);
        $ww = '';
        foreach($ss as $s){
            $ww .= ucfirst($s);
        }
        return $ww;
    }

    public function runJob($job)
    {
        $route = $job->task_name;
        $params = $job->unserializeParmas;

        $r = false;

        $cc = explode('/', $route);
        $class_name = "\\console\\jobs\\" . $this->camelcase($cc[0]) . 'Job';

        if (class_exists($class_name)){
            $jober = new $class_name;

            if (isset($cc[1])){
                $action_name = 'action' . $this->camelcase($cc[1]);
            } else {
                $action_name = $jober->defaultAction;
            }
            if (method_exists($jober, $action_name)){
                try {
                    $r = call_user_func_array([$jober, $action_name], $params);
                } catch (Exception $e){
                    $job->message = $e->getFile() . "\n" . $e->getLine() . "\n" . $e->getMessage() ;
                }
            } else {
                $job->message = "Job 找不到对应的action";
            }
        } else {
            $job->message = "找不到对应的job";
        }
        if ($r){
            $job->status = $job::STATUS_DONE;
        } else {
            $job->status = $job::STATUS_FAILED;
            $job->retryIfCan();
        }
        $job->save();
        return $r;
    }
}
