<?php
namespace common;

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
        preg_match("/iphone|android|ipad|ipod/", $user_agent, $matches);
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

}
