<?php
namespace m;

use Yii;
use common\BaseController;

class MBaseController extends BaseController
{
    public function beforeAction($action)
    {            
        Yii::$app->controller->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
}
