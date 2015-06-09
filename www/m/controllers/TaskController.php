<?php

namespace m\controllers;

use Yii;

use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Url;
use common\models\Task;
use common\models\Resume;
use common\models\District;
use common\models\TaskApplicant;


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

        $query = Task::find()->with('address');
        $query = $query->where(['city_id'=>$city_id]);
        if (!empty($district)){
            $query = $query->where(['district_id'=>$district]);
        }
        if (!empty($service_type)){
            $query = $query->where(['service_type_id'=>$service_type]);
        }
        $query->addOrderBy(['to_date'=>SORT_DESC]);
        $city = District::findOne($city_id);
        return $this->render('index', 
            ['tasks'=>$query->all(),
             'city'=>$city,
             'current_district' => 
                empty($district)?$city:District::findOne($district),
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
        if (!Resume::find()->where(['user_id'=>$user_id])->exists()){
            return $this->redirect('/resume/edit');
        }
        if ($task && !TaskApplicant::isApplied($user_id, $task->id)){
            $tc = new TaskApplicant;
            $tc->task_id = $task->id;
            $tc->user_id = Yii::$app->user->id;
            $tc->save();
        }
        return $this->redirect(Url::toRoute(['/task/view', 'gid'=>$gid]));
    }

    public function actionView()
    {
        $gid = Yii::$app->request->get('gid');
        $task = null;
        if ($gid){
            $task = Task::find()->where(['gid'=>$gid])
                ->with('address')->with('company')->one();
        }
        if ($task){
            return $this->render('view', 
                ['task'=>$task, ]
            );
        } else {
            $this->render404("未知的信息");
        }
    }

}
