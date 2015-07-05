<?php

namespace backend\controllers;

use Yii;
use backend\models\TaskPool;
use backend\models\TaskPoolWhiteList;
use backend\models\TaskPoolSearch;
use backend\BBaseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TaskPoolController implements the CRUD actions for TaskPool model.
 */
class TaskPoolController extends BBaseController
{


    public function getViewPath()
    {
        return Yii::getAlias('@backend/views/spider/task-pool');
    }

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
     * Lists all TaskPool models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TaskPoolSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TaskPool model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionTransfer($id=null, $company_name=null, $origin=null)
    {
        if ($company_name && $origin){
            if (Yii::$app->request->isPost){
                $w = TaskPoolWhiteList::find()->where(
                    ['attr'=> 'company_name', 'value'=>$company_name, 'origin'=> $origin]
                )->one();
                if (!$w){
                    $w = new TaskPoolWhiteList;
                }
                $w->origin = $origin;
                $w->attr = 'company_name';
                $w->value = $company_name;
                $w->is_white = true;
                $w->save();
            }
            return $this->render('transfer-company', [
                'tasks'=> $w->examineTaskPool()
            ]);
        }
        elseif ($id){
            $t = TaskPool::findOne($id);
            if ($t->status!=0){
                $this->redirectHtml('/task-pool', '该任务已经处理过，无法继续处理!');
            }
            $task = $t->exportTask();
            return $this->redirect('/task/update?id='.$task->id);
        }
    }



    /**
     * Creates a new TaskPool model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TaskPool();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing TaskPool model.
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
     * Deletes an existing TaskPool model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if ($model && $model->status==0){
            $model->status = 11;
            $model->save();
        } else {
            $this->redirectHtml('/task-pool', '该任务不存在或已经处理过!');
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the TaskPool model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TaskPool the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TaskPool::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
