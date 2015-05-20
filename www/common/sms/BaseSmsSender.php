<?php
namespace common\sms;

use Yii;

class BaseSmsSender
{
    public static function cacheVerifyCode($phonenum, $code)
    {
        $vcodes = Yii::$app->session->get('verify_codes');
        if (empty($vcodes)){
            $vcodes = [];
        }
        Yii::trace("verify code for $phonenum is $code");
        $vcodes[$phonenum] = $code;
        Yii::$app->session->set('verify_codes', $vcodes);
    }

    public static function validateVerifyCode($phonenum, $code)
    {
        $vcodes = Yii::$app->session->get('verify_codes');
        if (empty($vcodes) || !array_key_exists($phonenum, $vcodes)){
            return false;
        }
        return $vcodes[$phonenum]==$code;
    }

    public static function generateVerifyCode()
    {
        return strval(rand(100000, 999999));
    }
}
