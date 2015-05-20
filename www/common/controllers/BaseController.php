<?php
namespace common\controllers;

use Yii;
use yii\web\Controller;


class BaseController extends Controller
{
    public function renderJson($data)
    {
        header('Content-type: application/json');
        echo json_encode($data, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
        Yii::$app->end();
    }
}
