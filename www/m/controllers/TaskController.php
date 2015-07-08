<?php

namespace m\controllers;

use Yii;

use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Url;
use common\Utils;
use common\models\Task;
use common\models\TaskCollection;
use common\models\TaskApplicant;
use common\models\Resume;
use common\models\District;
use common\models\ServiceType;
use yii\data\Pagination;


class TaskController extends \m\MBaseController
{

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'view'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['collect', 'apply'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'collect' => ['post'],
                ],
            ],
        ]);
    }

    public function actionIndex()
    {
        //只有北京
        $city_id = 3;
        $district = Yii::$app->request->get('district');
        $service_type = Yii::$app->request->get('service_type');
        if (empty($city_id)){
            $this->render404('未知的城市');
        }

        $query = Task::find();
        $query = $query->where(['city_id'=>$city_id]);
        if (!empty($district)){
            $query = $query->where(['district_id'=>$district]);
        }
        if (!empty($service_type)){
            $query = $query->where(['service_type_id'=>$service_type]);
        }
        $query->addOrderBy(['id'=>SORT_DESC]);
        $countQuery = clone $query;
        $pages =  new Pagination(['pageSize'=>Yii::$app->params['pageSize'],
            'totalCount' => $countQuery->count()]);
        $tasks = $query->offset($pages->offset)
            ->limit($pages->limit)->all();


        $city = District::findOne($city_id);
        return $this->render('index', 
            ['tasks'=>$tasks,
             'city'=>$city,
             'pages'=> $pages,
             'current_district' => 
                empty($district)?$city:District::findOne($district),
             'current_service_type' => empty($service_type)?null:ServiceType::findOne($service_type),
            ]);
    }

    public function actionApply()
    {
        $gid = Yii::$app->request->get('gid');
        $task = null;
        if ($gid){
            $task = Task::find()->where(['gid'=>$gid])->one();
        }
        if (!$task){
            $this->render404();
        }
        $user_id = Yii::$app->user->id;
        $resume = Resume::find()->where(['user_id'=>$user_id])->one();
        if (!$resume){
            return $this->redirect('/resume/edit');
        }
        if ($task && !TaskApplicant::isApplied($user_id, $task->id)){
            $tc = new TaskApplicant;
            $tc->task_id = $task->id;
            $tc->user_id = Yii::$app->user->id;

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
        return $this->redirect(Url::toRoute(['/task/view', 'gid'=>$gid]));
    }

    public function actionView()
    {
        $this->layout = 'main';

        $gid = Yii::$app->request->get('gid');
        $task = null;
        if ($gid){
            $task = Task::find()->where(['gid'=>$gid])
                ->with('city')->with('district')->one();
        }
        if ($task){
            $collected = false;
            $app = null;
            if (!Yii::$app->user->isGuest){
                $collected = TaskCollection::find()->where(
                    ['task_id'=>$task->id, 'user_id'=>Yii::$app->user->id])->exists();
                $app = TaskApplicant::find()->where(
                    ['task_id'=>$task->id, 'user_id'=>Yii::$app->user->id])->one();
            }
            return $this->render('view', 
                [
                    'task'=>$task,
                    'collected'=>$collected,
                    'app'=> $app,
                ]
            );
        } else {
            $this->render404("未知的信息");
        }
    }

}
