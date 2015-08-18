<?php
return [
    'adminEmail' => 'webmaster@miduoduo.cn',
    'supportEmail' => 'contact@miduoduo.cn',
    'supportTel' => '010-84991662',
    'bugEmail' => '1bbd853df30a46a695cd7d350bee6caa+lukps3jjzxxxx3gr1rzd@boards.trello.com',

    'baidu.map.server_key' => 'oUVOlwx2f8Ok7iGt30CcB2aQ',
    'baidu.map.web_key' => 'GB9AZpYwfhnkMysnlzwSdRqq',

    'user.passwordResetTokenExpire' => 3600,

    'baseurl.api' => 'http://api.miduoduo.cn',
    'baseurl.m' => 'http://m.miduoduo.cn',
    'baseurl.backend' => 'http://dashboard.miduoduo.cn',
    'baseurl.corp' => 'http://corp.miduoduo.cn',
    'baseurl.frontend' => 'http://www.miduoduo.cn',
    'baseurl.h5_origin' => 'http://origin.miduoduo.cn',
    'baseurl.media' => 'http://media.miduoduo.cn',
    'baseurl.wechat' => 'http://wechat.miduoduo.cn',
    'baseurl.model' => 'http://model.miduoduo.cn',

    'baseurl.static.m' => 'http://static.miduoduo.cn/m',
    'baseurl.static.www' => 'http://static.miduoduo.cn/www',
    'baseurl.static.corp' => 'http://static.miduoduo.cn/corp',
    'baseurl.static.dashboard' => 'http://static.miduoduo.cn/dashboard',

    'nearby_search.max_distance' => 10000, // 单位米
    'host_ip' => '',

    'downloadApp.android' => 'http://dd.myapp.com/16891/BFBA839C0F4B194CE8F700FAACBA1E89.apk',
    'downloadApp.ios' => 'https://itunes.apple.com/us/app/mi-duo-duo-jian-zhi/id1016364056?mt=8&uo=4',

    'wechat_payment.id' => '',
    'wechat_payment.key' => '',

    'weichat'=>[
        'appid'     => 'wxc940e677d43db45d',                // 微信公众号ID
        'secret'    => '284769fa88c6ba0496cc2aa06ef1d7c4',  // 微信secret
        'scope1'    => 'snsapi_base',                       // 获取基本信息
        'scope2'    => 'snsapi_userinfo',                   // 获取详细信息
        'pushset'   => [
            'pushtime'      => [1=>'12:00',2=>'19:30'],     // 推送时间
            'pushtype'      => [1=>'固定内容',2=>'用户偏好'],   // 推送类型
            'status'        => [1=>'启用',2=>'停用'],           // 状态
            'tmp_weichat'   => [1=>'兼职',2=>'通知'],           // 微信模板
        ],
        'tmp_weichat'  => [
            'quality'   => 'NoEWsq5BpBRdEymm3-W6YrYoBBkyWCFNUkfJhpCbYcc',     // 优单模板
            'nearby'    => 'qwENcjpEuIBn53LHyFh4-PmmpVaSmL04WpylDX1JkaE',     // 附近模板
            'applicant' => 'srIf6HPINf-I-BmlPJSqxfJ_E-ZUFlrp_D4MUUvQFOc',     // 报名成功
            'accountin' => 'Bo7ZbPipKywJ2kBdwCcJnF75fbhpRW4cvGoYHdLW8CY',     // 收入提醒
        ],
        'preview_user'  => '13699273824,18611299991,18210135925,13240055520',// 定时推送预览人员
    ],

    'config'=>[
        'recommend_type' => [       // 推荐信息分类
            1 => 'M端-首页推荐',
        ],
    ],

    'file_log' =>[
        'max_size'      => 20000,
        'log_base_url'  => '/var/miduoduo/miduoduo/www/user_logs/',
    ],

    /*
    开发账号 settings ，如果使用，请copy注释的部分到 params-local.php
        'weichat'=>[
            'appid'     => 'wxf18755b4d95797ac',                // 微信公众号ID
            'secret'    => '42e2440d817f1c4d2889790e2a3369e4',  // 微信secret
            'scope1'    => 'snsapi_base',                       // 获取基本信息
            'scope2'    => 'snsapi_userinfo',                   // 获取详细信息
            'pushset'   => [
                'pushtime'      => [1=>'12:00',2=>'19:30'],     // 推送时间
                'pushtype'      => [1=>'固定内容',2=>'用户偏好'],   // 推送类型
                'status'        => [1=>'启用',2=>'停用'],           // 状态
                'tmp_weichat'   => [1=>'兼职',2=>'通知'],           // 微信模板
            ],
            'tmp_weichat'  => [
                'quality'   => '3_dIRci_3IDpL3E1D69Vm17w_LB_4AM6ATB7f4Qw3H8',     // 优单模板
                'nearby'    => 'cMI9HFLDvuHJrhakSszPCre8oWaUA6nSVv74pCpoN3c',     // 附近模板
            ],
        ],
    */
];
