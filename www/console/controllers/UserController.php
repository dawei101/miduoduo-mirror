<?php
/**
 */

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\console\Exception;
use \common\models\User;

/**
 */

class UserController extends Controller
{
    /**
     * @var string controller default action ID.
     */
    public $defaultAction = 'list';


    public function actionList(){
    }


    public function actionAdd($phonenum, $password){
        $user = new User();
        $user->username = $phonenum;
        $user->setPassword($password);
        if ($user->validate()) {
            $user->save();
            echo "$phonenum创建完毕\n";
        }
        else {
            foreach($user->getErrors() as $key=>$errors){
                echo join('\n', $errors) . "\n";
            }
        }
    }

    public function actionSetRole($phonenum, $role_name)
    {
        $user = User::findOne(['username'=>$phonenum]);
        $auth = Yii::$app->authManager;
        $admin = $auth->getRole($role_name);
        $auth->assign($admin, $user->getId());
        echo "$phonenum 权限设置完毕\n";
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

