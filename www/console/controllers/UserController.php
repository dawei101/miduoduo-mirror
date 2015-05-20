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


    public function actionAdd($username, $password){
        $user = new User();
        $user->username = $username;
        $user->setPassword($password);
        if ($user->validate()) {
            $user->save();
        }
        else {
            foreach($user->getErrors() as $key=>$errors){
                echo join('\n', $errors) . "\n";
            }
        }
    }
}

