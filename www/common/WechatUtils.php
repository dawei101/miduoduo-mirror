<?php
namespace common;

use Yii;


class WechatUtils
{

    private static $_access_token;

    private static $_access_token_key = 'wechat_access_token';

    public static function makeAuthUrl($callback, $state='')
    {
        $appid   = Yii::$app->params['weichat']['appid'];
        $secret  = Yii::$app->params['weichat']['secret'];
        $scope   = Yii::$app->params['weichat']['scope1'];

        return 'https://open.weixin.qq.com/connect/oauth2/authorize?'
            . 'appid=' . $appid . '&redirect_uri=' . urlencode($callback)
            . '&response_type=code&scope=' . $scope
            . '&state=' . urlencode($state) . '#wechat_redirect';
    }

    public static function getAccessToken()
    {
        $appid = Yii::$app->params['weichat']['appid'];
        $secret = Yii::$app->params['weichat']['secret'];
        if (!static::$_access_token){
            static::$_access_token = 
                Yii::$app->global_cache->get(static::$_access_token_key);
            if(!static::$_access_token){
                $getTokenUrl = 
                    'https://api.weixin.qq.com/cgi-bin/token'
                    . '?grant_type=client_credential'
                    . '&appid='.$appid.'&secret='.$secret;

                $arr = static::getUrlJson($getTokenUrl);
                static::$_access_token = $arr['access_token'];
                Yii::$app->global_cache->set(
                    static::$_access_token_key,
                    static::$_access_token,
                    1.8 * 60 * 60);
            }
        }
        return static::$_access_token;
    }

    public static function getUrlJson($targetUrl,$getData=''){
        // 请求的数据
        $error = false;
        $data = [];
        $retry = 3;
        while ($retry>0 && empty($data))
        {
            $curlobj    = curl_init();
            curl_setopt($curlobj, CURLOPT_URL, $targetUrl);
            curl_setopt($curlobj, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curlobj, CURLOPT_HEADER, 0);
            curl_setopt($curlobj, CURLOPT_POSTFIELDS, $getData);
            curl_setopt($curlobj, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($curlobj, CURLOPT_SSL_VERIFYHOST, FALSE);
            $returnstr  = curl_exec($curlobj);
            if(!curl_error($curlobj) ){
                $data = json_decode($returnstr, true);
            }
            curl_close($curlobj);
            $retry -= 1;
        }
        return $data;
    }

    public static function getUserTokenByCode($code)
    {
        $appid   = Yii::$app->params['weichat']['appid'];
        $secret  = Yii::$app->params['weichat']['secret'];
        $scope   = Yii::$app->params['weichat']['scope1'];
        $url = 'https://api.weixin.qq.com/sns/oauth2/access_token'
            .'?appid=' . $appid . '&secret=' . $secret
            . '&code=' . $code . '&grant_type=authorization_code';
        return static::getUrlJson($url);
    }


}