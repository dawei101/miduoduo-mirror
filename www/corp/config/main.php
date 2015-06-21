<?php
$param_files = 
    [__DIR__ . '/../../common/config/params.php',
     __DIR__ . '/../../common/config/params-local.php',
     __DIR__ . '/params.php',
     __DIR__ . '/params-local.php'];

$params = [];

foreach ($param_files as $f){
    if (file_exists($f)){
        $params = array_merge($params, require($f));
    }
}




return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'user'=>[
            'class' => 'yii\web\User',
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => 'site/login',
        ],
       'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'cache' => [
            'class' => 'yii\caching\DbCache',
            'db' => 'db',
            'cacheTable' => 'jz_cache_for_backend',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'rules' => [
                // your rules go here
            ],
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=miduoduo',
            'username' => 'root',
            'password' => '123123',
            'charset' => 'utf8',
        ],
    ],
    'params' => $params,
];
