<?php
namespace m\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Url;

use common\Utils;
use common\models\LoginWithDynamicCodeForm;
use common\models\LoginForm;
use common\sms\SmsSenderFactory;

use m\MBaseController;
use m\models\ResetPasswordForm;
use m\models\SignupForm;

/**
 * Site controller
 */
class UserController extends MBaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup', 'vcode'],
                'rules' => [
                    [
                        'actions' => ['signup', 'vcode', 'vsignup', 'vlogin', 'login', 'setPassword'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post', 'get'],
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

    public function actionVcode()
    {
        $phonenum = Yii::$app->request->get('phonenum');
        if (!Utils::isPhonenum($phonenum)){
            return $this->renderJson([
                'result'=> false,
                'msg'=> "手机号码不正确"
            ]);
        }
        $sender = SmsSenderFactory::getSender();
        if ($sender->sendVerifyCode($phonenum)){
            return $this->renderJson([
                    'result'=> true,
                    'msg'=> "验证码已发送"
            ]);
        }
        return $this->renderJson([
                'result'=> false,
                'msg'=> "验证码发送失败, 请稍后重试。"
        ]);
    }

    public function actionVlogin($signuping=false)
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginWithDynamicCodeForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if ($signuping){
                $url = Url::to([
                        '/user/reset-password',
                        'next' => '/resume/edit'
                    ]);
                return $this->redirect($url);
            } else {
                return $this->redirect('/user/reset-password');
            }
        } else {
            return $this->render('vlogin', [
                'model' => $model,
                'signuping' => $signuping,
            ]);
        }
    }

    public function actionVsignup()
    {
        return $this->actionVlogin($signuping=true);
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }


    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionResetPassword()
    {
        $user = Yii::$app->user->identity;
        $model = new ResetPasswordForm($user);
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            $next = Yii::$app->request->get('next');
            if (!empty($next)){
                return $this->redirect($next);
            }
            return $this->goBack();
        }
        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
