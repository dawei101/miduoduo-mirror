<?php
 
namespace api\modules\v1\controllers;

use Yii;
use yii\filters\AccessControl;
use api\modules\BaseActiveController;
 
use common\Utils;
use common\sms\SmsSenderFactory;
use common\sms\BaseSmsSender;
use common\models\User;
use common\models\Device;

/**
 * Entry Controller API
 *
 * @author dawei
 */
class EntryController extends BaseActiveController
{
    public $modelClass = 'common\models\User';


    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'signup', 'vlogin',
                        'vcode', 'vcode-for-signup', 'report-device',
                        'report-push-id', 'check-update',
                    ],
                        'allow' => true,
                    ],
                ],
            ],
        ];
    }

    public function actionReportDevice()
    {
        $device = $this->distillDeviceFromRequest(Yii::$app->request);
        if ($device){
            $device->save();
            return $this->renderJson([
                'success'=> true,
                'message'=> '记录成功',
                ]);
        }
        return $this->renderJson([
            'success'=> false,
            'message'=> '未知的设备信息',
            ]);
    }

    public function distillDeviceFromRequest($request)
    {
        $device_id = Utils::getDeviceId($request);
        $device_info = $request->headers->get('User-Agent');
        $app_version = Utils::getAppVersion($request);
        if (empty($device_id)||empty($device_info)||empty($app_version)){
            return null;
        }
        $device = Device::find()->where(['device_id'=>$device_id])->one();
        if (!$device){
            $device = new Device();
            $device->device_id = $device_id;
        }
        $device->device_info = $device_info;
        $device->app_version = $app_version;
        return $device;
    }

    public function actionReportPushId()
    {
        $push_id = Yii::$app->request->post('push_id');
        if (empty($push_id)){
            return $this->renderJson([
                'success'=> false,
                'message'=> '没有push id信息',
                ]);
        }
        $device = $this->distillDeviceFromRequest(Yii::$app->request);
        if ($device){
            $device->push_id = $push_id;
            $device->save();
            return $this->renderJson([
                'success'=> true,
                'message'=> '记录成功',
                ]);
        }
        return $this->renderJson([
            'success'=> false,
            'message'=> '未知的设备信息',
            ]);
    }

    public function actionCheckUpdate()
    {
        $user_agent = Yii::$app->request->headers->get('User-Agent');
        $device_type = Utils::getDeviceType($user_agent);
        if (!$device_type){
            return $this->renderJson([
                'success'=> false,
                'message'=> '未知的设备信息',
                ]);
        }
        $version = AppReleaseVersion::find()->where(['device_type'=>$device_type])
            ->orderBy(['id'=>SORT_DESC])->one();

        return $this->renderJson([
            'success'=> true,
            'message'=> '获取成功',
            'result'=>$version->asArray()
            ]);
    }

    public function activeDevice($user)
    {
        $device_type = Utils::getDeviceType(Yii::$app->request->get('User-Agent'));
        if ($device_type){
            $device = $this->distillDeviceFromRequest(Yii::$app->request);
            $device->user_id = $user->id;
            $device->access_token = $user->access_token;
            $device->save();
        }
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
                    $this->activeDevice($user);
                    return $this->renderJson([
                        'success'=> true,
                        'message'=> '登录成功',
                        'result'=> [
                            'id'=> $user->id,
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
                'success'=> false,
                'message'=> "手机号码不正确"
            ]);
        }
        $sender = SmsSenderFactory::getSender();
        if ($sender->sendVerifyCode($phonenum)){
            return $this->renderJson([
                    'success'=> true,
                    'message'=> "验证码已发送"
            ]);
        }
        return $this->renderJson([
                'success'=> false,
                'message'=> "验证码发送失败, 请稍后重试。"
        ]);
    }

    public function actionVcodeForSignup()
    {
        $phonenum = Yii::$app->request->post('phonenum');

        $user = User::findByUsername($phonenum);
        if ($user){
            return $this->renderJson([
                'success'=> false,
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
            $this->activeDevice($user);
            $user->save();
            return $this->renderJson([
                'success'=> true,
                'message'=> '登录成功',
                'result'=> [
                    'id'=> $user->id,
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
                'success'=> false,
                'message'=> "手机号码已被注册，请直接登陆"
            ]);
        }
        return $this->actionVlogin();
    }
}
