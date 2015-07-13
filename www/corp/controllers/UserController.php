<?php
namespace corp\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;

use common\Utils;
use common\models\LoginWithDynamicCodeForm;
use common\models\User;
use common\sms\SmsSenderFactory;
use common\models\Company;
use common\models\ServiceType;

use corp\FBaseController;
use corp\models\PasswordResetRequestForm;
use corp\models\ResetPasswordForm;
use corp\models\SignupForm;
use corp\models\LoginForm;
use corp\models\ContactForm;
use corp\models\PersonalCertForm;

/**
 * Site controller
 */
class UserController extends FBaseController
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
                        'actions' => ['login', 'register', 'vcode','request-password-reset', 'reset-password'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['add-contact-info','logout', 'info', 'account', 'personal-cert', 'corp-cert'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['get'],
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

    public function actionLogin()
    {
        $loginModel = new LoginForm();
        if ($loginModel->load(Yii::$app->request->post(), '') && $loginModel->login()) {
            return $this->renderJson(['result' => true ]);
        }

        return $this->renderJson(['result' => false, 'error' => $loginModel->errors]);
    }

    public function actionRegister()
    {
        $regModel = new SignupForm();
        if ($regModel->load(Yii::$app->request->post(), '')) {
            if ($user = $regModel->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->renderJson(['result' => true]);
                }
            }
        }

        return $this->renderJson(['result' => false, 'error' => $regModel->errors]);
    }

    public function actionVcode($username)
    {
        if (!Utils::isPhonenum($username)){
            return $this->renderJson([
                'result'=> false,
                'msg'=> "手机号码不正确"
            ]);
        }

        if (Utils::sendVerifyCode($username)){
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

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post(), '') && $model->validate()) {
            $token = $model->verifyPhone();
            if ($token !== false) {
                return $this->redirect(array('/user/reset-password', 'token' => $token));
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    public function actionResetPassword($token='')
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            // throw new Bad RequestHttpException($e->getMessage());
            //just for test
            return $this->render('resetPassword');
        }

        if ($model->load(Yii::$app->request->post(), '') && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword');
    }

    public function actionAddContactInfo()
    {
        $model = new Company;
        $model->setAttributes(Yii::$app->request->post(), false);
        if ($model->validate() && $model->save()) {
            return $this->goHome();
        }
        return $this->render('addContactInfo', ['model' => $model]);
    }

    public function actionInfo()
    {
        $company = Company::findByCurrentUser();
        if (!$company) {
            return $this->redirect('/user/add-contact-info');
        }

        if (Yii::$app->request->isPost) {
            $company->setAttributes(Yii::$app->request->post(), false);
            if ($company->validate() && $company->save()) {
                return $this->goHome();
            }
        }

        $services = ServiceType::find()->all();
        return $this->render('info', ['company' => $company, 'services' => $services]);
    }

    public function actionAccount()
    {
        if (Yii::$app->request->isPost) {
            $old_password = Yii::$app->request->post('old_password');
            $new_password = Yii::$app->request->post('new_password');
            $confirm = Yii::$app->request->post('confirm');
            if (strcmp($new_password, $confirm) != 0) {
                return $this->render('account', ['errmsg'=>'新密码不一致']);
            }
            $user = User::findIdentity(Yii::$app->user->id);
            if (!$user->validatePassword($old_password)) {
                return $this->render('account', ['errmsg'=>'原密码错误']);
            }

			$user->setPassword($new_password);
        	$user->removePasswordResetToken();
            if ($user->validate() && $user->save()) {
                return $this->goHome();
            }
        }

        return $this->render('account', ['errmsg'=>'']);
    }

    public function actionPersonalCert()
    {
    	$company = Company::findByCurrentUser();

    	if(Yii::$app->request->isPost){
            $hash = Yii::$app->getSecurity()->generateRandomString();
    		$uploaddir = '/var/www/uploads/';
			$uploadfile = $uploaddir . $hash;//basename($_FILES['person_idcard_pic']['name']);
			if(!move_uploaded_file($_FILES['person_idcard_pic']['tmp_name'], $uploadfile)) {
                return $this->render('personal-cert',['company' => $company, 'error'=>'上传文件错误']);
            }
            $company->setAttributes(Yii::$app->request->post(), false);
            $company->person_idcard_pic = $hash;
            if (!$company->validate() || !$company->save()) {
                return $this->render('personal-cert',['company' => $company, 'error'=>$company->errors]);
            }
            return $this->goHome();
    	}
        return $this->render('personal-cert',['company' => $company, 'error'=>false]);
    }

    public function actionCorpCert()
    {
        $company = Company::findByCurrentUser();
    	if(Yii::$app->request->isPost){
            $hash = Yii::$app->getSecurity()->generateRandomString();
    		$uploaddir = '/var/www/uploads/';
			$uploadfile = $uploaddir . $hash;//basename($_FILES['person_idcard_pic']['name']);
			if(!move_uploaded_file($_FILES['person_idcard_pic']['tmp_name'], $uploadfile)) {
                return $this->render('personal-cert',['company' => $company, 'error'=>'上传文件错误']);
            }
            $company->setAttributes(Yii::$app->request->post(), false);
            $company->person_idcard_pic = $hash;
            if (!$company->validate() || !$company->save()) {
                return $this->render('personal-cert',['company' => $company, 'error'=>$company->errors]);
            }
            return $this->goHome();
    	}
        return $this->render('corp-cert',['company'=>$company, 'error'=>false]);
    }
}
