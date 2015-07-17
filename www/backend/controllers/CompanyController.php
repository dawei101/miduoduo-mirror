<?php

namespace backend\controllers;

use Yii;
use common\models\Company;
use common\models\CompanySearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\BBaseController;

/**
 * CompanyController implements the CRUD actions for Company model.
 */
class CompanyController extends BBaseController
{
    /**
     * Lists all Company models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CompanySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Company model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


    public function actionSearch($keyword)
    {
        $query = Company::find()->where(['like', 'name', $keyword]);
        $cs = $query->all();
        $cs_arr = [];
        foreach($cs as $c){
            $cs_arr[] = $c->toArray();
        }
        return $this->renderJson($cs_arr);
    }

    /**
     * Creates a new Company model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Company();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Company model.
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

    public function changeStatus($id, $status)
    {
        Company::updateAll(['status'=> $status], 'id=:id',
            $params=[':id'=>$id]);
        return $this->redirect(['index']);
    }

    public function actionDelete($id)
    {
        return $this->changeStatus($id, $status=Company::STATUS_DELETED);
    }

    public function actionBlacklist($id)
    {
        return $this->changeStatus($id, $status=Company::STATUS_BLACKLISTED);
    }


    public function actionExamine($id, $value, $passed=false)
    {
        $company = $this->findModel($id);
        if ($company){
            if ($passed){
                $company->status = $company->status 
                    | $value | Company::EXAM_STARTED;
            } else {
                $company->status = ($company->status
                    & ~$value) | Company::EXAM_STARTED;
            }
            $company->save();
        }
        return $this->redirect(['index']);
 
    }

    public function actionRejectLicenseId($id)
    {
        return $this->actionExamine($id, Company::EXAM_GOVID_PASSED, false);
    }

    public function actionAdoptLicenseId($id)
    {
        return $this->actionExamine($id, Company::EXAM_GOVID_PASSED, true);
    }

    public function actionRejectGovId($id)
    {
        return $this->actionExamine($id, Company::LICENSE_PASS_EXAM, false);
    }

    public function actionAdoptGovId($id)
    {
        return $this->actionExamine($id, Company::LICENSE_PASS_EXAM, true);
    }

    protected function findModel($id)
    {
        if (($model = Company::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
