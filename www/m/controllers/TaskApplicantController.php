<?php

namespace m\controllers;

use Yii;

use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\TaskApplicant;


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

        $tc = TaskApplicant::find()->where(['task_id'=>$task_id,
            'user_id'=>$user_id
        ])->asArray()->one();

        if (!$tc){
            $tc = new TaskApplicant;

            // 记录渠道
            $origin = Yii::$app->session->get('origin') ? Yii::$app->session->get('origin') : '';
            if( $origin ){
                $tc->origin = $origin;
            }
        
            $tc->task_id = $task_id;
            $tc->user_id = $user_id;

            $tc->save();
            return $this->renderJson([
                'success'=> true,
                'message' => '报名成功',
            ]);
        }else{
            return $this->renderJson([
                'success'=> false,
                'message' => '请勿重复报名',
            ]);
        }
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



