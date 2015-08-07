<?php
 
namespace api\modules\v1\controllers;

use Yii;
use yii\filters\AccessControl;
use api\modules\BaseActiveController;
 
use common\Utils;
use common\models\User;
use common\models\Resume;
use common\models\WeichatUserInfo;
use api\common\Utils as AUtils;

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
        return ['set-password'];
    }

    public function actionProfile()
    {
        $user = Yii::$app->user->identity;
        return $this->renderJson([
            'success'=> true,
            'message'=> "获取成功",
            'result' => AUtils::formatProfile($user),
        ]);
    }

    public function actionBindThirdPartyAccount()
    {
        $params = Yii::$app->request->post('params');
        $platform = Yii::$app->request->post('platform');
        $result = false;
        $function =  'bind'. ucfirst($platform);
        if (method_exists($this, $function)){
            $result = $this->$function($params);
        }
        return $this->renderJson([
            'success'=> $result,
            'message'=> $result?"绑定成功":"绑定失败",
        ]);
    }

    public function bindWechat($params)
    {
        $user_id = Yii::$app->user->id;
        WeichatUserInfo::updateAll(['userid'=>0], ['userid'=>$user_id]);
        $winfo = WeichatUserInfo::find()
            ->where(['openid'=>$params['openid']])->one();
        if (!$winfo){
            $winfo = new WeichatUserInfo;
        }
        $winfo->openid = $params['openid'];
        $winfo->userid = $user_id;
        if (isset($params['nickname'])){
            $winfo->weichat_name = $params['nickname'];
        }
        if (isset($params['headimgurl'])){
            $winfo->weichat_head_pic = $params['headimgurl'];
        }
        $winfo->status = WeichatUserInfo::STATUS_OK;
        return $winfo->save();
    }

    public function actionSetPassword()
    {
        $password = Yii::$app->request->post('password');
        $password2 = Yii::$app->request->post('password2');
        if (empty($password) || strlen($password)<6)
        {
            return $this->renderJson([
                'success'=> false,
                'message'=> "请保证密码不小于6位数",
            ]);
        }
        if ($password!=$password2)
        {
            return $this->renderJson([
                'success'=> false,
                'message'=> "两次密码输入不一致",
            ]);
        }
        $user = Yii::$app->user->identity;
        $user->setPassword($password);
        $user->generateAccessToken();
        $user->save();
        return $this->renderJson([
            'success'=> true,
            'message'=> "修改成功",
            'result' => [
                'id'=> $user->id,
                'username'=> $user->username,
                'password'=> $password,
                'access_token'=> $user->access_token,
                'resume' => $user->resume?$user->resume->toArray():null,
            ],
        ]);
    }
}
