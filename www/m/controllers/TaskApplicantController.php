<?php

namespace m\controllers;

use Yii;

use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use common\Utils;
use common\models\TaskApplicant;
use common\models\Task;
use common\models\Resume;


class TaskApplicantController extends \m\MBaseController
{
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['create', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'create' => ['post'],
                    'delete' => ['post'],
                ],
            ],

        ]);
    }

    public function actionCreate()
    {
        $task_id = Yii::$app->request->post('task_id');
        $user_id = Yii::$app->user->id;

        if (!$task_id){
            $this->render404();
        }
        $task = Task::findOne($task_id);
        if (!$task){
            $this->render404();
        }

        $tc = TaskApplicant::findOne(
            ['task_id'=>$task_id, 'user_id'=>$user_id ]);

        if (!$tc){
            $resume = Resume::find()->where(['user_id'=>$user_id])->one();
            if (!$resume){
                return $this->renderJson([
                    'success'=> false,
                    'redirect_to'=> '/resume/edit',
                    'message' => '需要填写简历',
                ]);
            }

            $tc = new TaskApplicant;
            $tc->task_id = $task_id;
            $tc->user_id = $user_id;

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
                $tc->applicant_alerted = true;
                $tc->company_alerted = true;
            } else {
               Yii::$app->sms_pusher->push(
                    $resume->phonenum,
                    ['task'=>$task, 'resume'=>$resume],
                    'to-applicant-task-need-touch-actively'
                );
                $tc->company_alerted = false;
                $tc->applicant_alerted = true;
            }
            $tc->save();
            return $this->renderJson([
                'success'=> true,
                'message' => '报名成功',
            ]);
        }
        return $this->renderJson([
                'success'=> false,
                'message' => '已报过名',
            ]);
    }

    public function actionDelete()
    {
        TaskApplicant::deleteAll('user_id = :user_id AND task_id = :task_id',
            [':user_id' => Yii::$app->user->id,
             ':task_id' => Yii::$app->request->post('task')]);
        return $this->renderJson([
            'success'=> true,
            'message' => '取消成功',
        ]);
    }
}



