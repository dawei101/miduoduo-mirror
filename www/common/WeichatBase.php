<?php
namespace common;

use Yii;
use yii\helpers\Url;
use Exception;
use common\models\WeichatAccesstoken;
use common\models\WeichatUserLog;

class WeichatBase
{

    static $session = null;

    public static function getSession(){

        if (!static::$session) {
            static::$session = new WeichatBase();
        }
        return static::$session;
    }

    private $_access_token_key = 'wechat_access_token';


    //运行时access_token 有可能在cache释放
    private $_access_token = null;

    /**
     *
     * getWeichatAccessToken 获取当前有效的微信access-token
     *
     * 如果token过期，脚本会自动获取新的token
     *
     * @author suixb
     * @return str access-token
     *
     */


    public function getWeichatAccessToken(){

        if (!$this->_access_token){
            $this->_access_token = Yii::$app->cache->get($this->_access_token_key);
            if(!$this->_access_token){
                $appid = Yii::$app->params['weichat']['appid'];
                $secret = Yii::$app->params['weichat']['secret'];
                $getTokenUrl = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$secret;
                $json = $this->getWeichatAPIdata($getTokenUrl);
                $arr = json_decode($json); 
                $this->_access_token = $arr->access_token;
                Yii::$app->cache->set(
                    $this->_access_token_key,
                    $this->_access_token, 1.8 * 60 * 60);
            }
        }
        return $this->_access_token;
    }

    /**
     * 
     * postWeichatAPIdata 使用post方法，向微信接口发送请求
     *
     * @author suixb
     * @param string $targetUrl 请求的接口地址
     * @param string $postData 发送的数据如： id=123&name=北京 
     * @return str 微信返回的结果
     *
     */
    public function postWeichatAPIdata($targetUrl,$postData){
        // 请求的数据
        $curlobj    = curl_init();
        curl_setopt($curlobj, CURLOPT_URL,$targetUrl);
        curl_setopt($curlobj, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlobj, CURLOPT_HEADER, 0);
        curl_setopt($curlobj, CURLOPT_POST,1);
        curl_setopt($curlobj, CURLOPT_POSTFIELDS,$postData);
        curl_setopt($curlobj, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curlobj, CURLOPT_SSL_VERIFYHOST, FALSE);
        $returnstr  = curl_exec($curlobj);
        if( curl_error($curlobj) ){
            $returnstr  = 'haserror';
        }
        curl_close($curlobj);
        
        return $returnstr;
    }

    /**
     * 
     * getWeichatAPIdata 使用post方法，向微信接口发送请求
     *
     * @author suixb
     * @param string $targetUrl 请求的接口地址
     * @param string $getData 发送的数据如： id=123&name=北京 
     * @return str 微信返回的结果
     *
     */
    public function getWeichatAPIdata($targetUrl,$getData=''){
        // 请求的数据
        $curlobj    = curl_init();
        curl_setopt($curlobj, CURLOPT_URL, $targetUrl);
        curl_setopt($curlobj, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlobj, CURLOPT_HEADER, 0);
        curl_setopt($curlobj, CURLOPT_POSTFIELDS, $getData);
        curl_setopt($curlobj, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curlobj, CURLOPT_SSL_VERIFYHOST, FALSE);
        $returnstr  = curl_exec($curlobj);
        if( curl_error($curlobj) ){
            $returnstr  = 'haserror';
        }
        curl_close($curlobj);
        
        return $returnstr;
    }

    // 保存用户微信行为数据
    public function saveEventLog($openid,$event_type){
        $userModel  = new WeichatUserLog();
        $userModel->openid          = (string)$openid;
        $userModel->created_time    = date("Y-m-d H:i:s",time());
        $userModel->event_type      = $event_type;
        $userModel->save();
    }

    private $_ticket_key = '_wechat_jsapi_ticket';

    public function getJsapiTicket()
    {
        $ticket = Yii::$app->cache->get($this->_ticket_key);
        if (!$ticket) {
            $baseurl = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token="
                . $this->getWeichatAccessToken()
                ."&type=jsapi";
            $retry = 3;
            while ($retry>0 && !$ticket){
                try {
                    $c = file_get_contents($baseurl);
                    $arr = json_decode($c);
                    if ($arr->errcode==0){
                        $ticket = $arr->ticket;
                        Yii::$app->cache->set(
                            $this->_ticket_key, $ticket, 1.8 * 60 * 60);
                    }
                    Yii::info("Wechat jsapi ticket response code is " . $arr->errorcode);
                } catch (Exception $e) {
                    Yii::warning("Get wechat jsapi ticket failed with error: " . $e->getMessage());
                }
                $retry -= 1;
            }
        }
        if (!$ticket) {
            throw new Exception('微信出错');
        }
        return $ticket;
    }

    public function signParams($params){
        ksort($params);
        $s = '';
        foreach ($params as $k=>$v){
            $s .= strtolower($k) . '=' . $v . '&';
        }
        $s = substr($s, 0, -1);
        return sha1($s);
    }

    public function generateConfigParams()
    {
        $params = [
            'url'=> Url::current([], $scheme=true),
            'nonceStr'=> ''. rand(100000, 999999),
            'jsapi_ticket'=> $this->getJsapiTicket(),
            'timestamp'=> time(),
        ];
        $params['signature'] = $this->signParams($params);
        unset($params['url']);
        $params['debug'] = YII_DEBUG;
        $params['appId'] = Yii::$app->params['weichat']['appid'];
        return $params;
    }
}
