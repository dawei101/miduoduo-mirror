<?php

namespace common\pusher;

use Yii;

use common\WeichatBase;
use common\models\WeichatPushLog;

class WechatPusher extends WeichatBase
{
    public function push($user_id, $tpl_name, $params)
    {
        echo 'test';
    }

    /**
     *
     * pushWeichatMsg 使用消息模板给微信关注用户推送消息
     *
     * 使用消息模板给微信关注用户推送消息
     * @author suixb
     * @param string $touser 推送目标用户微信ID(openid)
     * @param string $weichatTempID 微信消息模板ID
     * @param array $params 消息模板数据
                            $params         = array(
                                array('name'=>'first','value'=>'恭喜你购买成功！','color'=>'#444'),   
                                ......
                            );
     * @param str $gotoUrl 点击消息链接目标地址
     * $param str $topcolor 不知道干嘛的
     * @return boolean 发送成功与否
     *
     */
    public function pushWeichatMsg($touser,$weichatTempID,$params,$gotoUrl='http://m.miduoduo.cn',$pushGroup='',$topcolor='#1BBC9B'){
        // access_token,7200秒过期
        $access_token   = $this->getWeichatAccessToken();
        // 推送消息接口地址
        $targetUrl      = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$access_token;
        
        // 将 $params 够造成消息体 $data
        $data           = '';
        foreach( $params as $k => $v ){
            $data   .= '
                "'.$v['name'].'": {
                   "value":"'.$v['value'].'",
                   "color":"'.$v['color'].'"
                },'
            ;
        }
        $data       = trim($data,',');

        // 根据传入的参数构造消息内容
        $content    = '
            {
               "touser":"'.$touser.'",
               "template_id":"'.$weichatTempID.'",
               "url":"'.$gotoUrl.'",
               "topcolor":"'.$topcolor.'",
               "data":{
                   '.$data.'    
               }
           }
        ';

        // 发送消息动作
        $returnMsg  = $this->postWeichatAPIdata($targetUrl,$content);
        
        // bao cun fa song ri zhi 
        $this->savePushLog($returnMsg,$touser,$pushGroup);

    }

    // 保存推送消息日志
    private function savePushLog($returnMsg,$openid,$pushGroup=''){
        // 解析
        $returnArr  = json_decode($returnMsg);
        $result     = $returnArr->errmsg;
        $pushGroup  = $pushGroup ? $pushGroup : uniqid();

        // 保存日志
        $log        = new WeichatPushLog();
        $log->push_group    = $pushGroup;
        $log->openid        = $openid;
        $log->create_time   = date("Y-m-d H:i:s",time());
        $log->result        = $result;
        $log->return_msg    = $returnMsg;
        $log->save();
    }
}
