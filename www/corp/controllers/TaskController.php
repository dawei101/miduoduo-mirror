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
use common\models\ServiceType;
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
        $company = Company::findByCurrentUser();
        if (!$company) {
            return $this->redirect('/user/add-contact-info');
        }
        $condition = ['user_id'=>Yii::$app->user->id];
        $status = Yii::$app->request->get('status');
        if (array_key_exists('status', $_GET)) {
            $condition['status'] = $status;
        }
        $query = Task::find()
                        ->where($condition)
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
        if (Yii::$app->request->isPost) {
            $company_id = $company->id;
            $data = Yii::$app->request->post();
            $data['company_id'] = $company_id;
            $data['user_id'] = Yii::$app->user->id;
            $model->setAttributes($data, false);

            $clearance_period = Yii::$app->request->post('clearance_period');
            if ($clearance_period) {
                $model->clearance_period = array_search($clearance_period, Task::$CLEARANCE_PERIODS);
            }
            $salary_unit = Yii::$app->request->post('salary_unit');
            if ($salary_unit) {
                $model->salary_unit = array_search($salary_unit, Task::$SALARY_UNITS);
            }
            $gender_requirement = Yii::$app->request->post('gender_requirement');
            if ($gender_requirement) {
                $model->gender_requirement = array_search($gender_requirement, Task::$GENDER_REQUIREMENT);
            }
            $height_requirement = Yii::$app->request->post('height_requirement');
            if ($height_requirement) {
                $model->height_requirement = array_search($height_requirement,Task::$HEIGHT_REQUIREMENT);
            }
            $face_requirement = Yii::$app->request->post('face_requirement');
            if ($face_requirement) {
                $model->face_requirement = array_search($face_requirement,Task::$FACE_REQUIREMENT);
            }
            $talk_requirement = Yii::$app->request->post('talk_requirement');
            if ($talk_requirement) {
                $model->talk_requirement = array_search($talk_requirement,Task::$TALK_REQUIREMENT);
            }
            $health_certificated = Yii::$app->request->post('health_certificated');
            if ($health_certificated) {
                $model->health_certificated = array_search($health_certificated,Task::$HEALTH_CERTIFICATED);
            }
            $degree_requirement = Yii::$app->request->post('degree_requirement');
            if ($degree_requirement) {
                $model->degree_requirement = array_search($degree_requirement,Task::$DEGREE_REQUIREMENT);
            }
            $weight_requirement = Yii::$app->request->post('weight_requirement');
            if ($weight_requirement) {
                $model->weight_requirement = array_search($weight_requirement,Task::$WEIGHT_REQUIREMENT);
            }
            $model->service_type_id = ServiceType::findOne(['name' => Yii::$app->request->post('service_type_id')])->id;
            $model->status = 30;
            if ($model->validate() && $model->save()) {
                return $this->redirect('/task/success');
            }
        }

		$services = ServiceType::find()->all();
        return $this -> render('publish',
        ['services'=>$services, 'task'=>$model, 'company'=>$company]);
    }

    public function actionEdit($gid)
    {
        $company = Company::findByCurrentUser();
        if (!$company) {
            return $this->redirect('/user/add-contact-info');
        }

        $task = Task::findOne(['gid' => $gid]);
        if (!$task) {
            return $this->goHome();
        }
        if (Yii::$app->request->isPost) {
            $task->setAttributes(Yii::$app->request->post(), false);

            $clearance_period = Yii::$app->request->post('clearance_period');
            if ($clearance_period) {
                $task->clearance_period = array_search($clearance_period, Task::$CLEARANCE_PERIODS);
            }
            $salary_unit = Yii::$app->request->post('salary_unit');
            if ($salary_unit) {
                $task->salary_unit = array_search($salary_unit, Task::$SALARY_UNITS);
            }
            $gender_requirement = Yii::$app->request->post('gender_requirement');
            if ($gender_requirement) {
                $task->gender_requirement = array_search($gender_requirement, Task::$GENDER_REQUIREMENT);
            }
            $height_requirement = Yii::$app->request->post('height_requirement');
            if ($height_requirement) {
                $task->height_requirement = array_search($height_requirement,Task::$HEIGHT_REQUIREMENT);
            }
            $face_requirement = Yii::$app->request->post('face_requirement');
            if ($face_requirement) {
                $task->face_requirement = array_search($face_requirement,Task::$FACE_REQUIREMENT);
            }
            $talk_requirement = Yii::$app->request->post('talk_requirement');
            if ($talk_requirement) {
                $task->talk_requirement = array_search($talk_requirement,Task::$TALK_REQUIREMENT);
            }
            $health_certificated = Yii::$app->request->post('health_certificated');
            if ($health_certificated) {
                $task->health_certificated = array_search($health_certificated,Task::$HEALTH_CERTIFICATED);
            }
            $degree_requirement = Yii::$app->request->post('degree_requirement');
            if ($degree_requirement) {
                $task->degree_requirement = array_search($degree_requirement,Task::$DEGREE_REQUIREMENT);
            }
            $weight_requirement = Yii::$app->request->post('weight_requirement');
            if ($weight_requirement) {
                $task->weight_requirement = array_search($weight_requirement,Task::$WEIGHT_REQUIREMENT);
            }
            $task->service_type_id = ServiceType::findOne(['name' => Yii::$app->request->post('service_type_id')])->id;
            if ($task->validate() && $task->save()) {
                return $this->redirect('/task/success');
            }
        }
        $services = ServiceType::find()->all();
        $task->from_time = substr($task->from_time, 0, -3);
        $task->to_time = substr($task->to_time, 0, -3);
        return $this->render('publish',
        ['task' => $task, 'services'=>$services, 'company'=>$company]);
    }

    public function actionRefresh($gid)
    {
        $company = Company::findByCurrentUser();
        if (!$company) {
            return $this->redirect('/user/add-contact-info');
        }

        $company = Company::findByCurrentUser();
        if (!$company) {
            return $this->redirect('/user/add-contact-info');
        }

        $task = Task::findOne(['gid' => $gid]);
        $task->updated_time = date("Y-m-d H:i:s");
        $task->from_time = substr($task->from_time, 0, -3);
        $task->to_time = substr($task->to_time, 0, -3);
        if($task->save()){
            return $this->renderJson(['result' => true]);
        }
        return $this->renderJson(['result' => false, 'error' => $task->errors]);
    }

    public function actionDown($gid)
    {
        $company = Company::findByCurrentUser();
        if (!$company) {
            return $this->redirect('/user/add-contact-info');
        }

        $task = Task::findOne(['gid' => $gid]);
        $task->updated_time = time();
        $task->status = 10;
        $task->from_time = substr($task->from_time, 0, -3);
        $task->to_time = substr($task->to_time, 0, -3);
        if($task->save()){
            return $this->renderJson(['result' => true]);
        }
        return $this->renderJson(['result' => false, 'error' => $task->errors]);
    }

    public function actionDelete($gid)
    {
        $company = Company::findByCurrentUser();
        if (!$company) {
            return $this->redirect('/user/add-contact-info');
        }

        $task = Task::findOne(['gid' => $gid]);
        $task->updated_time = time();
        $task->status = 20;
        $task->from_time = substr($task->from_time, 0, -3);
        $task->to_time = substr($task->to_time, 0, -3);
        if($task->save()){
            return $this->renderJson(['result' => true]);
        }
        return $this->renderJson(['result' => false, 'error' => $task->errors]);
    }

    public function actionSuccess()
    {
        return $this->render('success');
    }

}
