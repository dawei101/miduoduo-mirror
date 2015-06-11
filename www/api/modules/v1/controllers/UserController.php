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
 * User Controller API
 *
 * @author dawei
 */
class UserController extends BaseActiveController
{
    public $modelClass = 'common\models\User';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['delete'], $actions['view'],
            $actions['create'], $actions['update'], $actions['index']);
        return $actions;
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'signup', 'vlogin', 'vcode'],
                        'allow' => true,
                    ],
                ],
            ],
        ];
    }

    public function actionLogin()
    {
        $phonenum = Yii::$app->request->post('username');
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

        return ['success'=> false, 'message'=> '用户名密码不正确'];
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

    public function actionVlogin()
    {
        $phonenum = Yii::$app->request->post('username');
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

    }
}
