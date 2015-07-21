<?php
$param_files = 
    [__DIR__ . '/../../common/config/params.php',
     __DIR__ . '/../../common/config/params-local.php',
     __DIR__ . '/params.php',
     __DIR__ . '/params-local.php'];

foreach ($param_files as $f){
    if (file_exists($f)){
        $params = array_merge($params, require($f));
    }
}

return [
    'id' => 'app-m',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'm\controllers',
    'defaultRoute'=>'site/',
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => '/user/login'
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
            'cacheTable' => 'jz_cache_for_m',
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'showScriptName' => false,
            'enablePrettyUrl' => true,
            'rules' => [
                'origin/h5v<version:[\d]+>/?' => 'origin/handle',
                'origin/h5v<version:[\d]+>/<file:[\-\.\_\w\d\/]+>' => 'origin/handle',
            ],
        ],
        'view' => [
            'class' => 'm\MView',
        ],
    ],
    'params' => $params,
];
