<?php
namespace common;

use Yii;

class Utils
{
    public static function isPhonenum($phonenum)
    {
        return preg_match("/^1[345789]\d{9}$/",$phonenum);
    }

    public static function getDeviceType($user_agent)
    {
        $user_agent = strtolower($user_agent);
        $matches = [];
        preg_match("/iphone|android|ipad|ipod/i", $user_agent, $matches);
        $os = current($matches);
        switch ($os){
            case 'android': 
                return Constants::DEVICE_ANDROID;
                break;
            case 'ipod' || 'iphone' || 'ipad' || 'ipod' || 'ios':
                return Constants::DEVICE_IOS;
                break;
        }
        return null;
    }

    public static function getAppVersion($request)
    {
        return $request->headers->get('App-Version');
    }

    public static function getDeviceId($request)
    {
        return $request->headers->get('Device-Id');
    }


    /*
     * 验证码跑龙套
     */

    public static function generateVerifyCode()
    {
        return strval(rand(1000, 9999));
    }

    public static function cacheVerifyCode($phonenum, $code)
    {
        Yii::trace("verify code for $phonenum is $code");
        Yii::$app->cache->set(static::getVcodeCachekey($phonenum), $code, 10*60);
    }

    public static function sendVerifyCode($phonenum)
    {
        $code = Utils::generateVerifyCode();
        Utils::cacheVerifyCode($phonenum, $code);
        $msg = "您的验证码为" . $code . ", 请不要告诉其他人【米多多】";
        return Yii::$app->sms_sender->send($phonenum, $msg);
    }

    public static function getVcodeCachekey($phonenum)
    {
        return 'vcode_for_' . $phonenum;
    }

    public static function validateVerifyCode($phonenum, $code)
    {
        $vcode = Yii::$app->cache->get(Utils::getVcodeCachekey($phonenum));
        return $vcode==$code;
    }

}
