<?php

namespace m\controllers;

use Yii;

use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use common\Utils;
use common\models\TaskApplicant;
use common\models\Task;
use common\models\Resume;
use common\models\WeichatUserInfo;
use common\models\WeichatUserLog;

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
            // 记录渠道
            $origin = Yii::$app->session->get('origin') ? Yii::$app->session->get('origin') : '';
            if( $origin ){
                $tc->origin = $origin;
            }
            $tc->task_id = $task_id;
            $tc->user_id = $user_id;

            if (Utils::isPhonenum($task->contact_phonenum)){
                // To 应聘者，如果绑定微信，并且为取消关注，就推送微信
                $weichat_id     = $this->get_weichatid();
                if( $weichat_id ){
                    $this->weichat_push($task,$weichat_id);
                }else{
                    Yii::$app->sms_pusher->push(
                        $resume->phonenum,
                        ['task'=>$task, 'resume'=>$resume],
                        'to-applicant-task-applied-done'
                    );
                }
                
                Yii::$app->sms_pusher->push(
                    $task->contact_phonenum,
                    ['task'=>$task, 'resume'=>$resume],
                    'to-company-get-new-application'
                );
                $tc->applicant_alerted = true;
                $tc->company_alerted = true;
            } else {
                // To 应聘者，如果绑定微信，并且为取消关注，就推送微信
                $weichat_id     = $this->get_weichatid();
                if( $weichat_id ){
                    $this->weichat_push($task,$weichat_id);
                }else{
                    Yii::$app->sms_pusher->push(
                        $resume->phonenum,
                        ['task'=>$task, 'resume'=>$resume],
                        'to-applicant-task-need-touch-actively'
                    );
                }
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

    // 报名微信推送消息
    public function weichat_push($task,$touser){
        // 微信推送
        $weichatTempID  = Yii::$app->params['weichat']['tmp_weichat']['applicant'];
        $params         = array(
            array('name'=>'first','value'=>'您好，本岗位您已报名成功','color'=>'#444'), 
            array('name'=>'keyword1','value'=>$task->gid,'color'=>'#444'),
            array('name'=>'keyword2','value'=>$task->title,'color'=>'#0000FE'),
            array('name'=>'keyword3','value'=>$task->from_date.'至'.$task->to_date,'color'=>'#444'),
            array('name'=>'keyword4','value'=>$task->address,'color'=>'#444'),
            array('name'=>'keyword5','value'=>$task->contact.' '.$task->contact_phonenum,'color'=>'#444'),
            array('name'=>'remark','value'=>"联系时，请告知是从米多多投递的。如遇任何招聘问题，请致电米多多。01084991662。也可点此内容进入职位详情投诉。",'color'=>'#999')
        );
        $gotoUrl        = Yii::$app->params['baseurl.m'].'/task/view?gid='.$task->gid;
        Yii::$app->wechat_pusher->pushWeichatMsg($touser,$weichatTempID,$params,$gotoUrl);
    }

    // 获取当前用户的绑定微信id
    public function get_weichatid(){
        $user_id    = Yii::$app->user->id;
        $openid_obj = WeichatUserInfo::find()->where(['userid'=>$user_id])->one();
        $openid     = isset($openid_obj->openid) ? $openid_obj->openid : 0;
        // 是否取消关注
        if( $openid ){
            // 最近一次取消关注
            $tdweichat_obj  = WeichatUserLog::find()
                ->where(['openid'=>$openid,'event_type'=>2])
                ->addOrderBy(['id'=>SORT_DESC])
                ->one();
            $tdweichat_id   = isset($tdweichat_obj->id) ? $tdweichat_obj->id : 0;
            if( $tdweichat_id ){
                // 最近一次关注
                $gzweichat_obj  = WeichatUserLog::find()
                    ->where(['openid'=>$openid,'event_type'=>1])
                    ->addOrderBy(['id'=>SORT_DESC])
                    ->one();
                $gzweichat_id   = isset($gzweichat_obj->id) ? $gzweichat_obj->id : 0;
                // 如果当前已经取消关注，返回false
                if( $tdweichat_id > $gzweichat_id ){
                    return false;
                }
            }
            return $openid;
        }else{
            return false;
        }
    }
}



