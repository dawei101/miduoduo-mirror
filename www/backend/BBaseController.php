<?php
namespace backend;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use common\BaseController;

class BBaseController extends BaseController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin', 'worker', 'hunter', 'saleman', 'supervisor', 'product_manager'],
                    ],

                ],

            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

}
