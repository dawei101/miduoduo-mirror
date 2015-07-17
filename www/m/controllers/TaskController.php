<?php

namespace m\controllers;

use Yii;

use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Url;
use common\Utils;
use common\models\Task;
use common\models\TaskAddress;
use common\models\TaskCollection;
use common\models\Complaint;
use common\models\TaskApplicant;
use common\models\Resume;
use common\models\District;
use common\models\ServiceType;
use yii\data\Pagination;
use common\models\WeichatPushSetTemplatePushItem;
use common\models\ConfigRecommend;
use common\models\UserLocation;

class TaskController extends \m\MBaseController
{

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'view','nearby', 'nearest','location'],
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

    public function actionNearest($lat, $lng, $distance=2000, $service_type=null)
    {
        $user_id    = Yii::$app->user->id;
        // 保存地理位置
        $location   = UserLocation::find()->where(['user_id'=>$user_id,'latitude'=>$lat])->one();
        $location_m = new UserLocation();
        $datetime   = date("Y-m-d H:i:s",time());
        if( $location ){
            $location->updated_time   = $datetime;
            $location->use_nums       = $location->use_nums + 1;
            $location->save();
        }else{
            $location_m->user_id    = $user_id;
            $location_m->latitude   = $lat;
            $location_m->longitude  = $lng;
            $location_m->created_time   = $datetime;
            $location_m->updated_time   = $datetime;
            $location_m->use_nums       = 1;
            $location_m->save();
        }

        $query = TaskAddress::find();
        $query = TaskAddress::buildNearbyQuery($query, $lat, $lng, $distance);
        $query->innerJoin('jz_task', $on='jz_task.id=jz_task_address.task_id');
        if ($service_type){
            $query->andWhere('jz_task.service_type_id=' . $service_type);
        }
        $query->andWhere(['jz_task.status'=>Task::STATUS_OK]);
        //$query->andWhere(['>', 'jz_task.to_date', date("Y-m-d")]);
        $query->addOrderBy(['jz_task.id'=>SORT_DESC]);
        $tas = $query->with('task')->all();

        $pages =  new Pagination(['pageSize'=>Yii::$app->params['pageSize'],
            'totalCount' => count($tas)]);

        $tasks = [];
        foreach ($tas as $ta){
            $task = $ta->task;
            $distance = $ta->distance($lat=$lat, $lng=$lng);
            $tasks[] = ['task'=>$task, 'distance'=>$distance];
        }

        uasort($tasks, function($a, $b){
            return $a['distance'] < $b['distance'] ? -1:1;
        });


        return $this->render('nearest', 
            ['tasks'=>array_slice($tasks, $pages->offset, $pages->limit),
             'pages'=> $pages,
             'current_service_type' => empty($service_type)?null:ServiceType::findOne($service_type),
            ]);
    }

    // 用户选择位置
    public function actionLocation(){
        $model      = UserLocation::findOne(['id'=>2]);
        return $this->render(
            'location',
            [
                'model'     => $model,
            ]
        );	
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
        $query->where(['status'=>Task::STATUS_OK]);
        $query->andWhere(['>', 'to_date', date("Y-m-d")]);

        $query = $query->andWhere(['city_id'=>$city_id]);
        if (!empty($district)){
            $query->andWhere(['district_id'=>$district]);
        }
        if (!empty($service_type)){
            $query->andWhere(['service_type_id'=>$service_type]);
        }
        $query->addOrderBy(['id'=>SORT_DESC]);
        $countQuery = clone $query;
        $pages =  new Pagination(['pageSize'=>Yii::$app->params['pageSize'],
            'totalCount' => $countQuery->count()]);
        $tasks = $query->offset($pages->offset)
            ->limit($pages->limit)->all();

        $city = District::findOne($city_id);
        
	// 查询当前用户的已有最新位置信
    $user_id    = Yii::$app->user->id;
	$location   = UserLocation::find()->where(['user_id'=>$user_id])
        ->asArray()->addOrderBy('`id` desc')->one();

    return $this->render('index', 
            ['tasks'=>$tasks,
             'city'=>$city,
             'pages'=> $pages,
             'current_district' => 
                empty($district)?$city:District::findOne($district),
             'current_service_type' => empty($service_type)?null:ServiceType::findOne($service_type),
             'location' => $location,    
	]);
    }

    public function actionView()
    {
        $this->layout = 'main';
        $user_id = Yii::$app->user->id;
        $resume =(bool) Resume::find()->where(['user_id'=>$user_id])->one();
        $gid = Yii::$app->request->get('gid');
        $task = null;
        if ($gid){
            $task = Task::find()->where(['gid'=>$gid])
                ->with('city')->with('district')->one();
        }
        if ($task){
            $collected = false;
            $complainted = false;
            $app = null;
            if (!Yii::$app->user->isGuest){
                $collected = TaskCollection::find()->where(
                    ['task_id'=>$task->id, 'user_id'=>Yii::$app->user->id])->exists();
                $complainted = Complaint::find()->where(
                    ['task_id'=>$task->id, 'user_id'=>Yii::$app->user->id])->exists();
                $app = TaskApplicant::find()->where(
                    ['task_id'=>$task->id, 'user_id'=>Yii::$app->user->id])->one();
            }
            return $this->render('view', 
                [
                    'task'=>$task,
                    'collected'=>$collected,
                    'complainted'=>$complainted,
                    'app'=> $app,
                    'resume'=> $resume,
                ]
            );
        } else {
            $this->render404("未知的信息");
        }
    }

    // 附近的兼职推荐
    public function actionNearby(){
        // 应该是周边兼职

        // 当前是固定内容推荐
        $temp_id    = is_numeric( Yii::$app->request->get('id') ) ? Yii::$app->request->get('id') : 0;
        // 查询列表的任务id
        $taskid_arr = WeichatPushSetTemplatePushItem::find()->where(['template_push_id'=>$temp_id])->asArray()->all();
        $taskid_str = '';
        foreach( $taskid_arr as $key => $value ){
            $taskid_str .= $value['task_id'].',';
        }
        $taskid_str = trim($taskid_str,',');

        $query = Task::find()->where("`gid` in($taskid_str)");

        // 任务排序功能
        $tasks = $query
            ->addOrderBy(['display_order'=>SORT_DESC])
            ->joinWith('weichanpushitem')
            ->all();

        return $this->render('nearby', 
            ['tasks'=>$tasks,
            ]);
    }

}
