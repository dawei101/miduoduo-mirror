<?php
namespace common;

use Yii;
use yii\helpers\Url;
use Exception;
use common\models\WeichatAccesstoken;
use common\models\WeichatUserLog;
use common\models\WeichatUserInfo;
use common\models\WeichatAutoresponse;
use common\models\Task;

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
            $this->_access_token = Yii::$app->global_cache->get($this->_access_token_key);
            if(!$this->_access_token){
                $appid = Yii::$app->params['weichat']['appid'];
                $secret = Yii::$app->params['weichat']['secret'];
                $getTokenUrl = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$secret;
                $json = $this->getWeichatAPIdata($getTokenUrl);
                $arr = json_decode($json); 
                $this->_access_token = $arr->access_token;
                Yii::$app->global_cache->set(
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

    public function makeAuthUrl($callback)
    {
        $appid   = Yii::$app->params['weichat']['appid'];
        $secret  = Yii::$app->params['weichat']['secret'];
        $scope   = Yii::$app->params['weichat']['scope1'];
        return 'https://open.weixin.qq.com/connect/oauth2/authorize?'
            . 'appid=' . $appid . '&redirect_uri=' . urlencode($callback)
            . '&response_type=code&scope=' . $scope
            . '&state=fromweichatrequest#wechat_redirect';
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
        $openid     = (string)$openid;

        $userModel  = new WeichatUserLog();
        $userModel->openid          = $openid;
        $userModel->created_time    = date("Y-m-d H:i:s",time());
        $userModel->event_type      = $event_type;
        $userModel->save();

        $status                 = $event_type==1 ? WeichatUserInfo::STATUS_OK : WeichatUserInfo::STATUS_CANCEL;
        $is_receive_nearby_msg  = $event_type==1 ? WeichatUserInfo::IS_RECEIVE_NEARBY_MSG_YES : WeichatUserInfo::IS_RECEIVE_NEARBY_MSG_NO;
        $this->updateWeichatStatus($openid,$status,$is_receive_nearby_msg);
    }

    private $_ticket_key = '_wechat_jsapi_ticket';

    public function getJsapiTicket()
    {
        $ticket = Yii::$app->global_cache->get($this->_ticket_key);
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
                        Yii::$app->global_cache->set(
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

    public function generateConfigParams($url=null)
    {
        $params = [
            'url'=> $url?$url:(Url::current([], $scheme=true)),
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

    // 获取当前登录用户的微信ID，如果用户未关注、取消关注 则返回false
    public function getLoggedUserWeichatID($user_id=''){
        $user_id    = $user_id ? $user_id : Yii::$app->user->id;
        $openid_obj = WeichatUserInfo::find()
            ->where(['userid'=>$user_id,'status'=>WeichatUserInfo::STATUS_OK])
            ->one();
        $openid     = isset($openid_obj->openid) ? $openid_obj->openid : 0;
        if( $openid ){
            return $openid;
        }else{
            return false;
        }
    }

    public function hasFollowed($openid){
        $openid_obj   = WeichatUserInfo::find()
            ->where(['openid'=>$openid,'status'=>WeichatUserInfo::STATUS_OK])
            ->one();
        $has_followed = isset($openid_obj->id) ? true : false;
        return $has_followed;
    }

    public function updateWeichatStatus($openid,$status,$is_receive_nearby_msg){
        WeichatUserInfo::updateAll(
            ['status'=>$status,'is_receive_nearby_msg'=>$is_receive_nearby_msg],
            ['openid'=>$openid]
        );
    }

    // 自动回复消息-关注
    public function autoResponseByFollowaction(){
        $model  = WeichatAutoresponse::find()->where(['type'=>1,'status'=>1])->One();
        return $model->response_msg;
    } 

    // 自动回复消息-未知关键词
    public function autoResponseByUnknownMsg(){
        $model  = WeichatAutoresponse::find()->where(['type'=>3,'status'=>1])->One();
        return $model->response_msg;
    } 

    // 自动回复消息-关键字
    public function autoResponseByKeyword($openid,$keyword=''){
        if( strtolower(trim($keyword)) == 'tdd' ){
            WeichatUserInfo::SwitchSubscribeDailyPush($openid,0);
            return '你已经成功退订每日兼职推送，如需重新订阅，请回复dyd。';
        }elseif( strtolower(trim($keyword)) == 'dyd' ){
            WeichatUserInfo::SwitchSubscribeDailyPush($openid,1);
            return '订阅每日兼职成功！每日兼职将每天为您推送最新最热的兼职信息。';
        }
        $model  = WeichatAutoresponse::find()
            ->where(['status'=>1])
            ->andWhere(['like','keywords',"%".$keyword."%",false])
            ->One();
        if( !empty($model->response_msg) ){
            return $model->response_msg;
        }else{
            // 未命中关键字，改为搜索任务名称
            $task_model = Task::find()
                ->where(['status'=>0])
                ->andWhere(['like','title',"%".$keyword."%",false])
                ->limit(10)->All();
            if( count($task_model)>0 ){
                return $this->renderTaskLink($task_model);
            }else{
                return false;
            }
        }
    }

    public function renderTaskLink($task_model){
        $msg_body   = '<ArticleCount>'.count($task_model).'</ArticleCount><Articles>';
        foreach( $task_model as $k => $v ){
            if( $k == 0 ){
                $img         = Yii::$app->params['baseurl.static.m'].'/static/img/wx_list1.jpg';
            }else{
                $img         = Yii::$app->params['baseurl.static.m'].'/static/img/wx_list2.jpg';
            }
            $url         = Yii::$app->params['baseurl.wechat']."/view/job/job-detail.html?task=".$v->id;
            $msg_body   .= '
                <item>
                <Title><![CDATA['.$v->title.']]></Title> 
                <Description><![CDATA['.$v->title.']]></Description>
                <PicUrl><![CDATA['.$img.']]></PicUrl>
                <Url><![CDATA['.$url.']]></Url>
                </item>
            ';
            
        }
        $msg_body .= '</Articles>';
        return $msg_body;
    }
}
