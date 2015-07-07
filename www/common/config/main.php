<?php
$root_path = dirname(dirname(__DIR__));

$params = [
        'weichat'=>[
            'appid'     => 'wxc940e677d43db45d',                // 微信公众号ID
            'secret'    => '284769fa88c6ba0496cc2aa06ef1d7c4',  // 微信secret
            'scope1'    => 'snsapi_base',                       // 获取基本信息
            'scope2'    => 'snsapi_userinfo',                   // 获取详细信息
            'pushset'   => [
                'pushtime'      => [1=>'上午9点',2=>'下午3点'],     // 推送时间
                'pushtype'      => [1=>'固定内容',2=>'用户偏好'],   // 推送类型
                'status'        => [1=>'启用',2=>'停用'],           // 状态
                'tmp_weichat'   => [1=>'兼职',2=>'通知'],           // 微信模板
            ],
        ],
    ];

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
        'app_pusher' => [
            'class' => 'common\pusher\AppPusher',
            'app_key' => '2ca0b9dfc8faa0381d1deb06',
            'master_secret' => '387ed21511f595ee278d29d1',
        ],
        'wechat_pusher' => [
            'class' => 'common\pusher\WechatPusher',
        ],
        'sms_pusher' => [
            'class' => 'common\pusher\SmsPusher',
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

    ],
    'aliases' => [
        'api' => $root_path . '/api',
        'm' => $root_path . '/m',
        'html5_src' => $root_path . '/html5_src',
        'html5_dest' => $root_path . '/html5_dest',
    ],
    'language'=>'zh-CN',
    'timeZone' => 'Asia/Shanghai',
    'params' => $params,
];
