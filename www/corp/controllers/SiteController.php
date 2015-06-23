<?php
namespace corp\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use corp\FBaseController;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use common\models\LoginWithDynamicCodeForm;

use corp\models\PasswordResetRequestForm;
use corp\models\ResetPasswordForm;
use corp\models\SignupForm;
use corp\models\LoginForm;
use corp\models\ContactForm;

/**
 * Site controller
 */
class SiteController extends FBaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                    'login' => ['post'],
                    'register' => ['post'],
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
        $regModel = new SignupForm();
        $loginModel = new LoginForm();
        return $this -> render('index',
        ['regModel' => $regModel, 'loginModel' => $loginModel]);
    }

    public function actionLogin()
    {
        $loginModel = new LoginForm();
        if ($loginModel->load(Yii::$app->request->post()) && $loginModel->login()) {
            return $this->renderJson(['result' => true ]);
        }

        return $this->renderJson(['result' => false]);
    }

    public function actionRegister()
    {
        $regModel = new SignupForm();
        if ($regModel->load(Yii::$app->request->post())) {
            if ($user = $regModel->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->renderJson(['result' => true]);
                }
            }
        }

        return $this->renderJson(['result' => false]);
    }
}
