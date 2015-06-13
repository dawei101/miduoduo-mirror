<?php
namespace m;

use Yii;
use common\BaseController;
use yii\web\HttpException;

class MBaseController extends BaseController
{
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function render404($msg='页面未找到')
    {
        throw new HttpException(404, $msg);
    }

    public function redirectWithSucceedMsg($to, $msg)
    {
        $view = Yii::getAlias('@m/views/common/success.php');
        return $this->renderFile($view,[
            'message'=>$msg,
            'next'=>$to,
        ]);
    }
}
