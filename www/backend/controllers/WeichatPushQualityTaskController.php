<?php

namespace backend\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use backend\BBaseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\WeichatUserInfo;
use common\pusher\WechatPusher;
use common\models\WeichatPushQualityTask;

/**
 * WeichatPushQualityTaskController implements the CRUD actions for WeichatPushQualityTask model.
 */
class WeichatPushQualityTaskController extends BBaseController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all WeichatPushQualityTask models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => WeichatPushQualityTask::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single WeichatPushQualityTask model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new WeichatPushQualityTask model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new WeichatPushQualityTask();

        $model->has_pushed  = 0;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing WeichatPushQualityTask model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing WeichatPushQualityTask model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    // 发送优单推送
    public function actionPushit($id){
        // 查询优单的数据
        $data   = WeichatPushQualityTask::find()->where(['id'=>$id])->asArray()->one();

        // 构造优单
        $params = array(
                //array('name'=>'first','value'=>$data['title'],'color'=>'#222'), 
                array('name'=>'keyword1','value'=>$data['company_name'],'color'=>'#222'),
                array('name'=>'keyword2','value'=>$data['task_name'],'color'=>'#222'),
                array('name'=>'keyword3','value'=>$data['task_type'],'color'=>'#222'),
                array('name'=>'keyword4','value'=>$data['location'],'color'=>'#222'),
                array('name'=>'keyword5','value'=>$data['price'],'color'=>'#0000FE'),
        );

        $gotoUrl        = Yii::$app->params['baseurl.m'].'/task/view?gid='.$data['gid'];

        // 得到待推送的用户列表
        // 这里只给 is_receive_nearby_msg=1 的用户发送推送
        $userlist       = WeichatUserInfo::find()->where(['is_receive_nearby_msg'=>1])->asArray()->all();

        // 本次推送的分组标识
        $pushGroup      = uniqid();
        
        // 此处需要优化，如果发送2W条，使用 长连接？分组方式？
        if( count($userlist) ){
            $pusher = new WechatPusher();
            foreach( $userlist as $key => $value ){
                $pusher->pushWeichatMsg(
                    $value['openid'],
                    Yii::$app->params['weichat']['tmp_weichat']['quality'],
                    $params,
                    $gotoUrl,
                    $pushGroup
                );
            }

            // 推送完毕，更新优单的信息
            $quality    = WeichatPushQualityTask::findOne($id);
            $quality->has_pushed    = 1;
            $quality->pushed_time   = date("Y-m-d H:i:s",time());
            $quality->push_group    = $pushGroup;
            $quality->update();
        }
    }

    /**
     * Finds the WeichatPushQualityTask model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return WeichatPushQualityTask the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = WeichatPushQualityTask::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
