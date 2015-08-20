<?php

namespace m\controllers;

use Yii;
use common\models\WeichatErweimaLog;
use common\models\WeichatErweimaLogSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\WeichatErweima;
use yii\web\HttpException;

/**
 * WeichatErweimaLogController implements the CRUD actions for WeichatErweimaLog model.
 */
class WeichatErweimaLogController extends Controller
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
     * Lists all WeichatErweimaLog models.
     * @return mixed
     */
    public function actionIndex()
    {
        // 验证传入参数
        $erweima_id = Yii::$app->request->get('id') ? Yii::$app->request->get('id') : 0;
        $erweima_scene_id = Yii::$app->request->get('sc') ? Yii::$app->request->get('sc') : 0;
        $erweima_m  = WeichatErweima::find()
            ->where(['id'=>$erweima_id,'scene_id'=>$erweima_scene_id])
            ->one();
        if( !$erweima_m ){
            throw new HttpException(404, '没有找到对应的二维码');
        }

        $searchModel = new WeichatErweimaLogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$erweima_id);

        $this->layout = 'bootstrap';
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single WeichatErweimaLog model.
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
     * Creates a new WeichatErweimaLog model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new WeichatErweimaLog();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing WeichatErweimaLog model.
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
     * Deletes an existing WeichatErweimaLog model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the WeichatErweimaLog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return WeichatErweimaLog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = WeichatErweimaLog::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
