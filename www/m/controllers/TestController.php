<?php
namespace m\controllers;

use m\MBaseController;


class TestController extends MBaseController
{
    public function actionIndex()
    {
        \Yii::$app->pusher->pushNotification(4, '测试');
    }
}
