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
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'modules' => [
        'v1' => [
            'basePath' => '@app/miduoduo/v1',
            'class' => 'api\miduoduo\v1\Module'
        ]
    ],
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableSession' => false,
            'enableAutoLogin' => false,
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
        'cache' => [
            'class' => 'yii\caching\DbCache',
            'db' => 'db',
            'cacheTable' => 'jz_cache',
            'keyPrefix' => 'api@',
        ],
        // 这里定义url
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => [
                        'v1/address',
                        'v1/offline-order',
                        'v1/resume',
                        'v1/freetime',
                        'v1/task',
                        'v1/task-applicant',
                        'v1/district',
                        'v1/complaint',
                        'v1/user-service-type',
                        'v1/service-type',
                        'v1/contact-us',
                        'v1/pay-account-event',
                        'v1/pay-withdraw',
                        'v1/recommend-task-group'
                    ],
                    'pluralize' => '',
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['v1/task-collection'],
                    'pluralize' => '',
                    'extraPatterns' => [
                        'GET exists/<id:\d+>' => 'exists',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['v1/freetime'],
                    'pluralize' => '',
                    'extraPatterns' => [
                        'POST free-all' => 'free-all',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['v1/message'],
                    'pluralize' => '',
                    'extraPatterns' => [
                        'POST update-all' => 'update-all',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['v1/sys-message'],
                    'pluralize' => '',
                    'extraPatterns' => [
                        'POST update-all' => 'update-all',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['v1/task-address'],
                    'pluralize' => '',
                    'extraPatterns' => [
                        'GET nearby' => 'nearby',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['v1/user'],
                    'pluralize' => '',
                    'patterns' => [
                        'POST set-password' => 'set-password',
                        'POST bind-third-party-account' => 'bind-third-party-account',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['v1/entry'],
                    'pluralize' => '',
                    'extraPatterns' => [
                        'POST login'=>'login',
                        'POST vcode'=>'vcode',
                        'POST vlogin'=>'vlogin',
                        'POST vcode-for-signup'=>'vcode-for-signup',
                        'POST signup'=>'signup',
                        'GET,POST report-device' => 'report-device',
                        'POST report-push-id' => 'report-push-id',
                        'GET,POST check-update' => 'check-update',
                        'POST t-login'=>'t-login',
                    ],
                ],
            ],
        ],
    ],
    'params' => $params,
];
