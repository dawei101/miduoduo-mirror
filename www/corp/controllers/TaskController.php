<?php
namespace corp\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use corp\FBaseController;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\Pagination;

use common\models\Company;
use common\models\Task;
use common\models\TaskAddress;

use corp\models\TaskPublishModel;

/**
 * Site controller
 */
class TaskController extends FBaseController
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
                         'actions' => ['index','publish', 'edit', 'refresh', 'down', 'delete'],
                         'allow' => true,
                         'roles' => ['@'],
                     ],
                 ],
             ],
             'verbs' => [
                 'class' => VerbFilter::className(),
                 'actions' => [
                     'logout' => ['post'],
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

    public function actionIndex()
    {
        $query = Task::find()
                        ->where(['user_id'=>Yii::$app->user->id])
                        ->addOrderBy(['updated_time'=>SORT_DESC]);;
        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count]);
        $tasks = $query->offset($pagination->offset)
                        ->limit($pagination->limit)
                        ->all();
        return $this -> render('index', ['tasks' => $tasks, 'pagination' => $pagination]);
    }

    public function actionPublish()
    {
        $model = new Task();
        $company = Company::findByCurrentUser();
        if (!$company) {
            return $this->redirect('/user/add-contact-info');
        }
        $company_id = $company->id;
        $data = Yii::$app->request->post();
        $data['company_id'] = $company_id;
        $data['user_id'] = Yii::$app->user->id;
        $model->setAttributes($data, false);
        if ($model->validate() && $model->save()) {
            return $this->redirect('/task/');
        }

        return $this -> render('publish');
    }

    public function actionEdit($gid)
    {
        $task = Task::findOne(['gid' => $gid]);
        if (!$task) {
            return $this->goHome();
        }
        if ($task->load(Yii::$app->request->post())) {
            if ($task->validate() && $task->save()) {
                return $this->redirect('/task/');
            }
        }
        return $this->render('publish', ['task' => $task]);
    }

    public function actionRefresh($gid)
    {
        $task = Task::findOne(['gid' => $gid]);
        $task->updated_time = time();
        $task->from_time = substr($task->from_time, -3);
        $task->to_time = substr($task->to_time, -3);
        if($task->save()){
            return $this->renderJson(['result' => false]);
        }
        return $this->renderJson(['result' => false, 'error' => $task->errors]);
    }

    public function actionDown($gid)
    {
        $task->updated_time = time();
        $task->status = 1;
        $task->from_time = substr($task->from_time, -3);
        $task->to_time = substr($task->to_time, -3);
        if($task->save()){
            return $this->renderJson(['result' => false]);
        }
        return $this->renderJson(['result' => false, 'error' => $task->errors]);
    }

    public function actionDelete($gid)
    {
        $task->updated_time = time();
        $task->status = 2;
        $task->from_time = substr($task->from_time, -3);
        $task->to_time = substr($task->to_time, -3);
        if($task->save()){
            return $this->renderJson(['result' => false]);
        }
        return $this->renderJson(['result' => false, 'error' => $task->errors]);
    }

}
