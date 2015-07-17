<?php
namespace corp\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use corp\CBaseController;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\db\Query;
use yii\data\Pagination;

use corp\models\TaskApplicant;
use common\models\Task;


/**
 * Site controller
 */
class ResumeController extends CBaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'read', 'pass', 'reject'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                    'login' => ['post'],
                    'register' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex($status=false)
    {
        $tasks = Task::findAll([
            'user_id'=>Yii::$app->user->id
        ]);
        $task_ids = [];
        foreach($tasks as $task){
            $task_ids[] = $task->id;
        }
        $query = TaskApplicant::find()
            ->where(['in', 'task_id', $task_ids]);
        if ($status!==false){
            $query->andWhere(['status'=>$status]);
        }

        $cloneQuery = clone $query;
        $count = $cloneQuery->count();
        $pagination = new Pagination(['totalCount' => $count]);
        $query-> with('resume')->with('task');
        $task_apps = $query->offset($pagination->offset)
                         ->limit($pagination->limit)
                         ->all();

        return $this -> render('index',
            ['task_apps' => $task_apps, 'pagination' => $pagination]);
    }

    public function actionRead($aid)
    {
        $resume = TaskApplicant::findOne(['id' => $aid]);
        $resume->have_read = 1;
        if ($resume->save()) {
            return $this->renderJson(['result' => true]);
        }
        return $this->renderJson(['result' => false, 'error' => $resume->errors]);
    }

    public function actionPass($aid)
    {
        $resume = TaskApplicant::findOne(['id' => $aid]);
        $resume->status = 10;
        if ($resume->save()) {
            return $this->renderJson(['result' => true]);
        }
        return $this->renderJson(['result' => false, 'error' => $resume->errors]);
    }

    public function actionReject($aid)
    {
        $resume = TaskApplicant::findOne(['id' => $aid]);
        $resume->status = 20;
        if ($resume->save()) {
            return $this->renderJson(['result' => true]);
        }
        return $this->renderJson(['result' => false, 'error' => $resume->errors]);
    }
}
