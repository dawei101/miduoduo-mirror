<?php
/**
 */

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\console\Exception;

/**
 */

class SpiderController extends Controller
{
    /**
     * @var string controller default action ID.
     */
    public $defaultAction = 'list';


    public function actionList(){
    }

    public function actionRun($phonenum, $role_name)
    {
        $user = User::findOne(['username'=>$phonenum]);
        if ($user){
            $auth = Yii::$app->authManager;
            $admin = $auth->getRole($role_name);
            $auth->assign($admin, $user->getId());
            echo "$phonenum 权限设置完毕\n";
        } else {
            echo "$phonenum 用户不存在\n";
        }
    }

    public function actionChangePassword($phonenum, $password)
    {
        $user = User::findOne(['username'=>$phonenum]);
        if (!$user){
            echo "No User found!\n";
        } else {
            $user->setPassword($password);
            $user->save();
            echo "Change done!\n";
        }

    }
}

