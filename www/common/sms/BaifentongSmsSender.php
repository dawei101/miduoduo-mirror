<?php
namespace common\sms;

use Yii;
use common\sms\SmsInterface;
use common\sms\BaseSmsSender;

class BaifentongSmsSender extends BaseSmsSender implements SmsInterface 
{
    public static $account = 'dlcsyj00';
    public static $password = 'gUp48QVj';

    public static function post($data, $url) {
        $url_info = parse_url($url);
        $httpheader = "POST " . $url_info['path'] . " HTTP/1.0\r\n";
        $httpheader .= "Host:" . $url_info['host'] . "\r\n";
        $httpheader .= "Content-Type:application/x-www-form-urlencoded\r\n";
        $httpheader .= "Content-Length:" . strlen($data) . "\r\n";
        $httpheader .= "Connection:close\r\n\r\n";
        //$httpheader .= "Connection:Keep-Alive\r\n\r\n";
        $httpheader .= $data;

        $fd = fsockopen($url_info['host'], 80);
        fwrite($fd, $httpheader);
        $gets = "";
        while(!feof($fd)) {
            $gets .= fread($fd, 128);
        }
        fclose($fd);
        if($gets != ''){
            $start = strpos($gets, '<?xml');
            if($start > 0) {
                $gets = substr($gets, $start);
            }
        }
        return $gets;
    }

    public function sendSms($phonenum, $content){
        Yii::trace("Sending to $phonenum with content: $content");
        $url = "http://cf.lmobile.cn/submitdata/Service.asmx/g_Submit";
        $posts = [
            'sname' => static::$account,
            'spwd'=> static::$password,
            'scorpid'=>'',
            'sprdid'=>'1012818',
            'sdst'=>$phonenum,
            'smsg'=>$content
        ];
        $post_data = http_build_query($posts);
        $content = static::post($post_data, $url);
        return strpos($content, '<State>0</State>')!==false;
    }

    public function sendVerifyCode($phonenum)
    {
        $code = static::generateVerifyCode();
        static::cacheVerifyCode($phonenum, $code);
        $msg = "您的验证码为" . $code . ", 请不要告诉其他人【米多多】";
        return $this->sendSms($phonenum, $msg);
    }
}
