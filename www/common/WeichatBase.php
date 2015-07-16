<?php
namespace common;

use Yii;
use common\models\WeichatAccesstoken;
use common\models\WeichatUserLog;
use common\models\WeichatUserInfo;

class WeichatBase{

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
        $access_token_arr   = WeichatAccesstoken::find()->asArray()->orderBy('id DESC')->one();
        // 判断是否已经过期了
        $created_time       = $access_token_arr['created_time'];
        $expires_in         = $access_token_arr['expires_in'] - 3600; // 获取每日限制100次，有效期2小时，这里如果 超过1小时，重新获取
        $time_now           = time();
        $time_diff          = $time_now - strtotime($created_time);
        // 如果过期，重新获取
        if( $time_diff > $expires_in ){
            $appid          = Yii::$app->params['weichat']['appid'];
            $secret         = Yii::$app->params['weichat']['secret'];
            $getTokenUrl    = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$secret;
            $token_json     = $this->getWeichatAPIdata($getTokenUrl);
            $token_arr      = json_decode($token_json); 

            // 将新的 access_token 保存起来
            $datetime       = date("Y-m-d H:i:s",time());
            $tokenobj       = new WeichatAccesstoken();
            $tokenobj->access_token = $token_arr->access_token;
            $tokenobj->expires_in   = $token_arr->expires_in;
            $tokenobj->created_time = $datetime;
            $tokenobj->update_time  = $datetime;
            $tokenobj->save();

            $access_token       = $token_arr->access_token;
            return $access_token;
        }else{
            $access_token       = $access_token_arr['access_token'];
            return $access_token;
        }
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
        curl_setopt($curlobj, CURLOPT_URL,$targetUrl);
        curl_setopt($curlobj, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlobj, CURLOPT_HEADER, 0);
        curl_setopt($curlobj, CURLOPT_POSTFIELDS,$getData);
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

    // 获取当前登录用户的微信ID，如果用户未关注、取消关注 则返回false
    public function getLoggedUserWeichatID(){
        $user_id    = Yii::$app->user->id;
        $openid_obj = WeichatUserInfo::find()->where(['userid'=>$user_id])->one();
        $openid     = isset($openid_obj->openid) ? $openid_obj->openid : 0;
        // 是否取消关注
        if( $openid ){
            // 最近一次取消关注
            $tdweichat_obj  = WeichatUserLog::find()
                ->where(['openid'=>$openid,'event_type'=>2])
                ->addOrderBy(['id'=>SORT_DESC])
                ->one();
            $tdweichat_id   = isset($tdweichat_obj->id) ? $tdweichat_obj->id : 0;
            if( $tdweichat_id ){
                // 最近一次关注
                $gzweichat_obj  = WeichatUserLog::find()
                    ->where(['openid'=>$openid,'event_type'=>1])
                    ->addOrderBy(['id'=>SORT_DESC])
                    ->one();
                $gzweichat_id   = isset($gzweichat_obj->id) ? $gzweichat_obj->id : 0;
                // 如果当前已经取消关注，返回false
                if( $tdweichat_id > $gzweichat_id ){
                    return false;
                }
            }
            return $openid;
        }else{
            return false;
        }
    }
}