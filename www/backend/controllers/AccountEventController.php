<?php

namespace backend\controllers;

use Yii;
use common\models\AccountEvent;
use common\models\AccountEventSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\BBaseController;

/**
 * AccountEventController implements the CRUD actions for AccountEvent model.
 */
class AccountEventController extends BBaseController
{

    public function behaviors()
    {
        $bhvs = parent::behaviors();
        return $bhvs;
    }

    /**
     * Lists all AccountEvent models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AccountEventSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpload(){
        if( Yii::$app->request->isPost && $_FILES['excelfile']['error'] == 0 && $_FILES['excelfile']['size'] > 0 ){
            $excel_path  = $_FILES['excelfile']['tmp_name'];
            $excel_data  = Yii::$app->office_phpexcel->excelToArray($excel_path);
            
            $accountevent      = new AccountEvent();
            $import_data       = $accountevent->saveUploadData($excel_data);
            if( $import_data ){
                $this->layout=false;
                return $this->render('upload', [
                    'import_data' => $import_data,
                ]);
            }else{
                echo '{"result"="false","errmsg"="上传错误"}';
            }
        }else{
            $excel_data = '';
            $this->layout=false;
            return $this->render('upload', [
                'excel_data' => $excel_data,
            ]);
        }
    }

    public function actionDownloaddemo(){
        $row_array  = [
            'A1'=>'日期',
            'B1'=>'职位id',
            'C1'=>'姓名',
            'D1'=>'用户id',
            'E1'=>'手机号',
            'F1'=>'身份证号',
            'G1'=>'金额',
            'H1'=>'金额说明',
            'A2'=>'2015-06-23',
            'B2'=>"'14374778022702043",
            'C2'=>'张三',
            'D2'=>'2043',
            'E2'=>'18611299991',
            'F2'=>"'110227166666666000",
            'G2'=>'5000',
            'H2'=>'日结工资',
        ];
        Yii::$app->office_phpexcel->arrayToExcel($row_array);
    }

    /**
     * Displays a single AccountEvent model.
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
     * Creates a new AccountEvent model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AccountEvent();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing AccountEvent model.
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
     * Deletes an existing AccountEvent model.
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
     * Finds the AccountEvent model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AccountEvent the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AccountEvent::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
