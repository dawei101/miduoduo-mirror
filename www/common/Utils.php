<?php
namespace common;

class Utils
{
    public static function isPhonenum($phonenum)
    {
        return preg_match("/^1[345789]\d{9}$/",$phonenum);
    }
}
