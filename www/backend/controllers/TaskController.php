<?php
namespace backend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;

use common\models\Company;
use common\models\Task;
use common\models\ServiceType;
use common\models\TaskAddress;

use backend\BBaseController;
use common\models\TaskSearch;
/**
 * Site controller
 */
header("content-type:text/html;charset=utf-8");
class TaskController extends BBaseController
{
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['operation_manager'],
                    ],
                ],
            ],
        ]);
    }

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
        $searchModel = new TaskSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPublish()
    {
        $model = new Task();

        if (Yii::$app->request->isPost) {
            
            $data = Yii::$app->request->post();
            
            $data['is_allday']   = isset($data['is_allday']) ? $data['is_allday'] : 0;
            $data['is_longterm'] = isset($data['is_longterm']) ? $data['is_longterm'] : 0;

            if( $data['is_longterm'] ){
                $data['to_date']    = '2115-01-01';
            }
            if( $data['is_longterm'] ){
                $data['from_time']  = '00:00:01';
                $data['to_time']    = '23:59:59';
            }

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

            $service_type_id = Yii::$app->request->post('service_type_id');
            if($service_type_id){
                $model->service_type_id = ServiceType::findOne(['name' => Yii::$app->request->post('service_type_id')])->id;
            }

            $recommend = Yii::$app->request->post('recommend');
            if($recommend){
                $model->recommend = array_search($recommend, Task::$RECOMMEND);
            } 

            $status = Yii::$app->request->post('status');
            if($status){
                $model->status = array_search($status, Task::$STATUSES);
            }
            

            if ($model->validate() && $model->save()) {
              
                $task_id = $model->id;
                $addressList = explode(' ', Yii::$app->request->post('address_list'));
                if(!in_array("", $addressList)){
                    foreach($addressList as $item){
                        $address = TaskAddress::findOne(['id' => $item]);
                        $address->task_id = $task_id;
                        $address->save();
                    }
                }
                

                return $this->redirect('/task/');
            }
        }

        $services = ServiceType::find()->all();
        return $this -> render('publish',
        ['services'=>$services, 'task'=>$model,  'address'=>[],]);
    }

    public function actionUpdate($id)
    {
        

        $company = Company::findByCurrentUser();

        $task = Task::findOne(['id' => $id]);
        if (!$task) {
            return $this->goHome();
        }
        if (Yii::$app->request->isPost) {
            $data   = Yii::$app->request->post();
            $data['is_allday']   = isset($data['is_allday']) ? $data['is_allday'] : 0;
            $data['is_longterm'] = isset($data['is_longterm']) ? $data['is_longterm'] : 0;

            if( $data['is_longterm'] ){
                $data['to_date']    = '2115-01-01';
            }
            if( $data['is_longterm'] ){
                $data['from_time']  = '00:00:01';
                $data['to_time']    = '23:59:59';
            }
          
            $task->setAttributes($data, false);

            $clearance_period = $data['clearance_period'];
            if ($clearance_period) {
                $task->clearance_period = array_search($clearance_period, Task::$CLEARANCE_PERIODS);
            }
            $salary_unit = $data['salary_unit'];
            if ($salary_unit) {
                $task->salary_unit = array_search($salary_unit, Task::$SALARY_UNITS);
            }
            $gender_requirement = $data['gender_requirement'];
            if ($gender_requirement) {
                $task->gender_requirement = array_search($gender_requirement, Task::$GENDER_REQUIREMENT);
            }
            $height_requirement = $data['height_requirement'];
            if ($height_requirement) {
                $task->height_requirement = array_search($height_requirement,Task::$HEIGHT_REQUIREMENT);
            }
            $face_requirement = $data['face_requirement'];
            if ($face_requirement) {
                $task->face_requirement = array_search($face_requirement,Task::$FACE_REQUIREMENT);
            }
            $talk_requirement = $data['talk_requirement'];
            if ($talk_requirement) {
                $task->talk_requirement = array_search($talk_requirement,Task::$TALK_REQUIREMENT);
            }
            $health_certificated = $data['health_certificated'];
            if ($health_certificated) {
                $task->health_certificated = array_search($health_certificated,Task::$HEALTH_CERTIFICATED);
            }
            $degree_requirement = $data['degree_requirement'];
            if ($degree_requirement) {
                $task->degree_requirement = array_search($degree_requirement,Task::$DEGREE_REQUIREMENT);
            }
            $weight_requirement = $data['weight_requirement'];
            if ($weight_requirement) {
                $task->weight_requirement = array_search($weight_requirement,Task::$WEIGHT_REQUIREMENT);
            }
            
            $service_type_id = $data['service_type_id'];
            if( $service_type_id){
                $task->service_type_id = ServiceType::findOne(['name' => $data['service_type_id']])->id;
            }
            
            $recommend = $data['recommend'];
            if($recommend){
                $task->recommend = array_search($recommend, Task::$RECOMMEND);
            } 

            $status = $data['status'];
            if($status){
                $task->status = array_search($status, Task::$STATUSES);
            }

            $task->updated_time = date("Y-m-d H:i:s");
            
            if ($task->validate() && $task->save()) {
                $task_id = $task->id;
                $addressList = explode(' ', $data['address_list']);
                foreach($addressList as $item){
                    $address = TaskAddress::findOne(['id' => $item]);
                    $address->task_id = $task_id;
                    $address->save();
                }
                return $this->redirect('/task/');
            }
        }
        $addresses = $task->getAddresses()->all();
        $services = ServiceType::find()->all();
        $task->from_time = substr($task->from_time, 0, -3);
        $task->to_time = substr($task->to_time, 0, -3);
        Yii::$app->session->set('current_task_id', $task->id);
        return $this->render('publish',
        ['task' => $task, 'services'=>$services, 'address'=>$addresses,]);
    }

    public function actionDown($gid)
    {
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

    public function actionDelete($id)
    {
        return $this->changeStatus($id, $status=Task::STATUS_DELETED);
    }

    public function actionSuccess()
    {
        return $this->render('success');
    }

    public function actionAddAddress()
    {
        $model = new TaskAddress();
        $model->setAttributes(Yii::$app->request->post(),false);
        $model->user_id = Yii::$app->user->id;
        $model->task_id = Yii::$app->session->get('current_task_id', 0);
        if($model->validate() && $model->save()){
            return $this->renderJson([
                'success'=> true,
                'msg'=> '创建成功',
                'result'=> $model->toArray()
            ]);
        }
        return $this->renderJson([
            'success'=> false,
            'msg'=> '创建失败',
            'errors'=> $model->getErrors(),
        ]);
    }

    protected function findModel($id){
        if( ($model = Task::findone($id)) !== null){
            return $model;
        }else{
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    public function actionDeleteAddress($id)
    {
        if( TaskAddress::findOne($id) !==null)
            TaskAddress::findOne($id)->delete();
        return $this->renderJson([
            'success'=> true,
            'msg'=> '删除成功',
        ]);
    }

    public function changeStatus($id, $status)
    {
        Task::updateAll(['status'=> $status], 'id=:id',
            $params=[':id'=>$id]);
        return $this->redirect(Yii::$app->request->referrer); 
    }
    public function actionReject($id)
    {
        return $this->changeStatus($id, $status=Task::STATUS_UN_PASSED);
    }
    public function actionAdopt($id)
    {
        return $this->changeStatus($id, $status=Task::STATUS_OK);
    }
    public function actionView($id){
        return $this->render('public');
    }


}
