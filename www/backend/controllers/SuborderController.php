<?php

namespace backend\controllers;

use Yii;
use yii\web\HttpException;
use common\models\Suborder;
use common\models\SuborderSearch;
use common\models\OfflineOrder;
use backend\BBaseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SuborderController implements the CRUD actions for Suborder model.
 */
class SuborderController extends BBaseController
{

    public $_order;
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

    public function beforeAction($action)
    {
        if (parent::beforeAction($action))
        {
            $id = \Yii::$app->request->get('order_id');
            $this->_order = OfflineOrder::findOne(['id'=>$id]);
            if (!$this->_order){
                throw new HttpException(404, '订单不存在');
            }
            return true;
        }
        return false;
    }

    /**
     * Lists all Suborder models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SuborderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'order' => $this->_order,
        ]);
    }

    /**
     * Displays a single Suborder model.
     * @param integer $order_id
     * @param integer $address_id
     * @return mixed
     */
    public function actionView($order_id, $address_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($order_id, $address_id),
            'order' => $this->_order,
        ]);
    }

    /**
     * Creates a new Suborder model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Suborder();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'order_id' => $model->order_id, 'address_id' => $model->address_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'order' => $this->_order,
            ]);
        }
    }

    /**
     * Updates an existing Suborder model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $order_id
     * @param integer $address_id
     * @return mixed
     */
    public function actionUpdate($order_id, $address_id)
    {
        $model = $this->findModel($order_id, $address_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'order_id' => $model->order_id, 'address_id' => $model->address_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Suborder model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $order_id
     * @param integer $address_id
     * @return mixed
     */
    public function actionDelete($order_id, $address_id)
    {
        $this->findModel($order_id, $address_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Suborder model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $order_id
     * @param integer $address_id
     * @return Suborder the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($order_id, $address_id)
    {
        if (($model = Suborder::findOne(['order_id' => $order_id, 'address_id' => $address_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
