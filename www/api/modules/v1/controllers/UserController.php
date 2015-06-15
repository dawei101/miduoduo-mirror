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
        return ['set-password'];
    }

    public function actionSetPassword()
    {
        $password = Yii::$app->request->post('password');
        $password2 = Yii::$app->request->post('password2');
        if (empty($password) || strlen($password)<6)
        {
            return $this->renderJson([
                'result'=> false,
                'message'=> "请保证密码不小于6位数",
            ]);
        }
        if ($password!=$password2)
        {
            return $this->renderJson([
                'result'=> false,
                'message'=> "两次密码输入不一致",
            ]);
        }
        $user = Yii::$app->user->identity;
        $user->setPassword($password);
        $user->generateAccessToken();
        $user->save();
        return $this->renderJson([
            'result'=> true,
            'message'=> "修改成功",
            'result' => [
                "username"=> $user->username,
                "password"=>$password,
                "access_token"=> $user->access_token,
            ],
        ]);
    }
}
