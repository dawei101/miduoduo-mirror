<?php

namespace backend\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Task;
use common\models\Company;
use common\models\TaskSearch;
use backend\BBaseController;

/**
 * TaskController implements the CRUD actions for Task model.
 */
class TaskController extends BBaseController
{

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
           'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'reject' => ['post'],
                    'adopt' => ['post'],
                ],
            ],
        ]);
    }



    /**
     * Lists all Task models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TaskSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    // public function actionIndex2()
    // {
    //     $searchModel = new TaskSearch();
    //     $dataProvider = $searchModel->search(Yii::$app->request->queryParams);//我想要改这个查询条件一个查询条件 默认参数是空的
    //     return $this->render('index2', [
    //         'searchModel' => $searchModel,
    //         'dataProvider' => $dataProvider,
    //     ]);
    // }

    /**
     * Displays a single Task model.
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
     * Creates a new Task model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Task();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['edit-address', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Task model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['edit-address', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionEditAddress($id)
    {
        $task = $this->findModel($id);

        return $this->render('edit-address',
            ['task'=>$task]
        );
    }

    public function changeStatus($id, $status)
    {
        Task::updateAll(['status'=> $status], 'id=:id',
            $params=[':id'=>$id]);
        return $this->redirect(Yii::$app->request->referrer); 
    }

    public function actionDelete($id)
    {
        return $this->changeStatus($id, $status=Task::STATUS_DELETED);
    }

    public function actionReject($id)
    {
        return $this->changeStatus($id, $status=Task::STATUS_UN_PASSED);
    }

    public function actionAdopt($id)
    {
        return $this->changeStatus($id, $status=Task::STATUS_OK);
    }



    /**
     * Finds the Task model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Task the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Task::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionPassed($id,$status){
        $model = $this->findModel($id);
        $model->status = $status;
        $model->save();   
        return $this->redirect(['task/index2']);
    }
}
