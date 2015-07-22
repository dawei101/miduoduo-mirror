<?php
namespace m\controllers;

use Yii;
use common\WeichatBase;


class WechatController extends \m\MBaseController
{

    public function actionEnv($callback=null)
    {
        $w = new WeichatBase;
        $config = $w->generateConfigParams();
        $env = [
            'wx_config'=> $w->generateConfigParams(),
            'baidu_map_key'=> Yii::$app->params['baidu.map.web_key'],
            ];
        $str = json_encode($env);
        if ($callback){
            header('Content-Type: application/javascript');
            echo $callback . "('" . $str . "')";
        } else {
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/json');
            echo $str;
        }
        exit();
    }

}
