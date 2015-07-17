<?php
namespace corp;

use Yii;
use yii\filters\AccessControl;
use common\BaseController;

class CBaseController extends BaseController
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['corp'],
                    ],
                ],
                'denyCallback' => function($rule, $action){
                    if (!Yii::$app->user->isGuest){
                        return $this->redirect('/user/add-contact-info');
                    }
                },
            ],
       ];
    }
}
