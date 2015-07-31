<?php
$root_path = dirname(dirname(__DIR__));

$project_root = dirname($root_path);

$params = [];

return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=miduoduo',
            'tablePrefix'=>'jz_',
            'username' => 'root',
            'password' => '123123',
            'charset' => 'utf8',
        ],
        'formatter' => [
            'class' => 'common\Formatter',
            'defaultTimeZone' => 'Asia/Shanghai',
            'timeZone' => 'Asia/Shanghai',
            'dateFormat' => 'php:Y-m-d',
            'datetimeFormat' => 'php:Y-m-d H:i',
            'timeFormat' => 'php:H:i:s',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.exmail.qq.com',  // e.g. smtp.mandrillapp.com or smtp.gmail.com
                'username' => 'support@chongdd.com',
                'password' => 'chongdd123',
                'port' => '465', // Port 25 is a very common port too
                'encryption' => 'ssl', // It is often used, check your provider or mail server specs
            ],
        ],
        'sms_sender' => [
            'class' => 'common\sms_sender\GuoduSender',
            'account' => 'bjcayj',
            'password' => 'cayj001',
        ],
        'voice_sender' => [
            'class' => 'common\voice_sender\YuntongxunSender',
            'account' =>'aaf98fda449fa4cc0144b3fe88fa0f5f',
            'app_id' => 'aaf98f894e91da24014e9538f64a027d',
            'account_token' => '160bc8047a564a129b5ca2ef7c51d79d',
        ],
        'app_pusher' => [
            'class' => 'common\pusher\AppPusher',
            'app_key' => 'fcdc25a74fa9d95484276160',
            'master_secret' => 'f9c837cfb26bd97dc8ed2201',
        ],
        'global_cache' => [
            'class' => 'yii\caching\DbCache',
            'db' => 'db',
            'cacheTable' => 'jz_cache',
            'keyPrefix' => 'corp@',
        ],
        'wechat_pusher' => [
            'class' => 'common\pusher\WechatPusher',
        ],
        'sms_pusher' => [
            'class' => 'common\pusher\SmsPusher',
        ],
        'job_queue_manager' => [
            'class' => 'common\JobQueueManager',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'assetManager' => [
            'appendTimestamp' => true,
        ],
       'session' => [
            'class' => 'yii\web\DbSession',
            'db' => 'db',
            'sessionTable' => '{{%session}}',
            'timeout' => 3600 * 24 * 30,
            'name' => 'sid',
       ],
       'message' => [
            'class' => 'common\message\Message',
       ],
       'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                ],
                [

                    'class' => 'yii\log\FileTarget',
                    'levels' => ['info'],
                    'categories' => ['user_location'],
                    'logFile' => '/service/data/logs/user-location/location.log',
                    'logVars'   => [],
                    'exportInterval'  => 0,
                    'maxFileSize' => 1024 * 10,
                    'maxLogFiles' => 20,
                    'enableRotation' => true,

               ],
            ],
        ],
    ],
    'aliases' => [
        'api' => $root_path . '/api',
        'm' => $root_path . '/m',
        'corp' => $root_path . '/corp',
        'jobs' => $root_path . '/console/jobs',
        'data' => '/service/data',
        'media' => '/service/data/media',
        'html5_src' => $project_root . '/frontend/dist/webapp',
        'html5_dest' => $root_path . '/html5_dest',
    ],
    'language'=>'zh-CN',
    'timeZone' => 'Asia/Shanghai',
    'params' => $params,
];
