<?php
 
namespace api\modules\v1\controllers;
 
use api\modules\BaseActiveController;
 
/**
 *  Controller API
 *
 * @author dawei
 */
class TaskApplicantController extends BaseActiveController
{
    public $modelClass = 'common\models\TaskApplicant';

    public $id_column = 'task_id';
    public $auto_filter_user = true;
    public $user_identifier_column = 'user_id';

    
    function actionCreate(){

        $resume = Resume::find()->where(['user_id'=>$user_id])->one();
        if (!$resume){
            return $this->renderJson([
                'success'=> false,
                'redirect_to'=> '/resume/edit',
                'message' => '需要填写简历',
            ]);
        }

        $tc = new TaskApplicant;
        // 记录渠道
        $origin = Yii::$app->session->get('origin') ? Yii::$app->session->get('origin') : '';
        if( $origin ){
            $tc->origin = $origin;
        }
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


    }
}
