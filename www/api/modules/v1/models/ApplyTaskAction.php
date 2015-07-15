<?php

namespace api\modules\v1\models;

use Yii;

use common\Utils;
use common\models\Resume;
use common\models\Task;
use common\models\TaskApplicant;


class ApplyTaskAction extends \yii\rest\CreateAction
{

    public function run()
    {
        $model = parent::run();

        $model->origin = 'App:' . Utils::getDeviceType(
            Yii::$app->request->getUserAgent()) 
            . '-' . Utils::getAppVersion(Yii::$app->request);

        $task = $model->task;
        $resume = $model->resume;

        if (Utils::isPhonenum($task->contact_phonenum)){
            Yii::$app->sms_pusher->push(
                $resume->phonenum,
                ['task'=>$task, 'resume'=>$resume],
                'to-applicant-task-applied-done'
            );
            Yii::$app->sms_pusher->push(
                $task->contact_phonenum,
                ['task'=>$task, 'resume'=>$resume],
                'to-company-get-new-application'
            );
            $model->applicant_alerted = true;
            $model->company_alerted = true;
        } else {
           Yii::$app->sms_pusher->push(
                $resume->phonenum,
                ['task'=>$task, 'resume'=>$resume],
                'to-applicant-task-need-touch-actively'
            );
            $model->company_alerted = false;
            $model->applicant_alerted = true;
        }

        $model->save();

        return $model;
    }

}
