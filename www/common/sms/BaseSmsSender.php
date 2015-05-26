<?php
namespace common\sms;

use Yii;

class BaseSmsSender
{

    public static function cacheVerifyCode($phonenum, $code)
    {
        Yii::trace("verify code for $phonenum is $code");
        Yii::$app->cache->set(static::getVcodeCachekey($phonenum), $code);
    }

    public static function getVcodeCachekey($phonenum)
    {
        return 'vcode_for_' . $phonenum;
    }

    public static function validateVerifyCode($phonenum, $code)
    {
        $vcode = Yii::$app->cache->get(static::getVcodeCachekey($phonenum));
        return $vcode==$code;
    }

    public static function generateVerifyCode()
    {
        return strval(rand(100000, 999999));
    }
}
