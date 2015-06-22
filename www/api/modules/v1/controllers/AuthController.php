<?php
 
namespace api\modules\v1\controllers;

use Yii;
use yii\filters\AccessControl;
use api\modules\BaseActiveController;
 
use common\Utils;
use common\sms\SmsSenderFactory;
use common\sms\BaseSmsSender;
use common\models\User;

/**
 * Auth Controller API
 *
 * @author dawei
 */
class AuthController extends BaseActiveController
{
    public $modelClass = 'common\models\User';

    public function actions()
    {
        return ['login', 'signup', 'vlogin',
            'vcode', 'vcode-for-signup', 'set-password'];
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'signup', 'vlogin',
                            'vcode', 'vcode-for-signup', 'set-password'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['set-password', ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionLogin()
    {
        $username = Yii::$app->request->post('phonenum');
        $password = Yii::$app->request->post('password');
        if(!(empty($username) || empty($password))){
            $user = User::findOne([
                'username' => $username,
            ]);
            if($user){
                if($user->validatePassword($password)){
                    $user->generateAccessToken();
                    $user->save();
                    return $this->renderJson([
                        'success'=> true,
                        'message'=> '登录成功',
                        'result'=> [
                            'username'=> $username,
                            'password'=> $password,
                            'access_token'=> $user->access_token,
                        ]
                    ]);
                }
            }
        }

        return $this->renderJson(['success'=> false,
            'message'=> '用户名密码不正确']);
    }

    public function actionVcode()
    {
        $phonenum = Yii::$app->request->post('phonenum');
        if (!Utils::isPhonenum($phonenum)){
            return $this->renderJson([
                'result'=> false,
                'message'=> "手机号码不正确"
            ]);
        }
        $sender = SmsSenderFactory::getSender();
        if ($sender->sendVerifyCode($phonenum)){
            return $this->renderJson([
                    'result'=> true,
                    'message'=> "验证码已发送"
            ]);
        }
        return $this->renderJson([
                'result'=> false,
                'message'=> "验证码发送失败, 请稍后重试。"
        ]);
    }

    public function actionVcodeForSignup()
    {
        $phonenum = Yii::$app->request->post('phonenum');

        $user = User::findByUsername($phonenum);
        if ($user){
            return $this->renderJson([
                'result'=> false,
                'message'=> "手机号码已被注册，请直接登陆"
            ]);
        }
        return $this->actionVcode();
    }


    public function actionVlogin()
    {
        $phonenum = Yii::$app->request->post('phonenum');
        $code = Yii::$app->request->post('code');

        if(BaseSmsSender::validateVerifyCode($phonenum, $code)){
            $user = User::findByUsername($phonenum);
            if (!$user){
                $user = User::createUserWithPhonenum($phonenum);
            }
            $user->generateAccessToken();
            $user->save();
            return $this->renderJson([
                'success'=> true,
                'message'=> '登录成功',
                'result'=> [
                    'username'=> $phonenum,
                    'password'=> '',
                    'access_token'=> $user->access_token,
                ]
            ]);
        }
        return $this->renderJson([
            'success'=> false,
            'message'=> "手机号或验证码不正确",
        ]);
    }

    public function actionSignup()
    {
        $phonenum = Yii::$app->request->post('phonenum');
        $user = User::findByUsername($phonenum);
        if ($user){
            return $this->renderJson([
                'result'=> false,
                'message'=> "手机号码已被注册，请直接登陆"
            ]);
        }
        return $this->actionVlogin();
    }

    public function actionSetPassword()
    {
        $password = Yii::$app->request->post('password');
        if (empty($password) || strlen($password)<6)
        {
            return $this->renderJson([
                'result'=> false,
                'message'=> "请保证密码不小于6位数",
            ]);
        }
        //TODO 
        return $this->renderJson([
            'result'=> false,
            'message'=> "api未完成",
        ]);
    }
}
