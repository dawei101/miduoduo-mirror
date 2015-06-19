<?php
namespace common\sms;

use common\sms\BaifentongSmsSender;

class SmsSenderFactory
{
    /** 如果有其他短信服务商，可通过map实例化指定sender
     */
    public static function getSender()
    {
        return new BaifentongSmsSender;
    }
}
