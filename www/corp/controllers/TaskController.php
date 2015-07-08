<?php
namespace corp\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use corp\FBaseController;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Task;
use common\models\TaskAddress;

use corp\models\TaskPublishModel;

/**
 * Site controller
 */
class TaskController extends FBaseController
{
    /**
     * @inheritdoc
     */
     public function behaviors()
     {
         return [
             'access' => [
                 'class' => AccessControl::className(),
                 'rules' => [
                     [
                         'actions' => ['index','publish'],
                         'allow' => true,
                         'roles' => ['@'],
                     ],
                 ],
             ],
             'verbs' => [
                 'class' => VerbFilter::className(),
                 'actions' => [
                     'logout' => ['post'],
                 ],
             ],
         ];
     }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this -> render('index');
    }

    public function actionPublish()
    {
        $model = new TaskPublishModel();
        $company_id = Yii::$app->getSession()->setFlash('success', 'New password was saved.');
        $data = Yii::$app->request->post();
        $data['company_id'] = $company_id;

        if ($model->load($data, '')) {
            print_r($model);
        }
        return $this -> render('publish');
    }

}
