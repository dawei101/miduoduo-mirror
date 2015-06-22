<?php

namespace common\sms;


interface SmsInterface
{
    public function sendSms($phonenum, $content);
    public function sendVerifyCode($phonenum);
}
