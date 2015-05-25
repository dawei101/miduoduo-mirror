<?php
namespace api\modules\v1;

use yii\filters\auth\HttpBasicAuth;
use common\models\User;

/**
 * Daai API V1 Module
 * 
 * @author Dawei
 * @since 1.0
 */
class Module extends \yii\base\Module
{
    public $controllerNamespace = 'api\modules\v1\controllers';

    public function init()
    {
        parent::init();        
        \Yii::$app->user->enableSession = false;
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::className(),
            'auth' => [$this, 'auth']
            ];
        return $behaviors;
    }

    /**
     * Finds user by username and password
     *
     * @param string $username
     * @param string $password
     * @return static|null
     */
    public function auth($username, $password) {
        if(empty($username) || empty($password))
            return null;

        $user = User::findOne([
            'username' => $username,
        ]);

        if(empty($user))
            return null;

        // if password validation fails
        if(!$user->validatePassword($password))
            return null;

        return $user;
    }
}
