<?php
$root_path = dirname(dirname(__DIR__));
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
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
    ],
    'aliases' => [
        'api' => $root_path . '/api',
        'm' => $root_path . '/m'
    ],
    'language'=>'zh-CN',
];
