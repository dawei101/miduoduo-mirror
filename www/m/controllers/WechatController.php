<?php
namespace m\controllers;

use Yii;
use yii\helpers\Url;
use common\WeichatBase;
use common\WechatUtils;
use common\models\WeichatUserInfo;
use api\common\Utils as AUtils;


class WechatController extends \common\BaseController
{

    public function actionEnv($callback=null)
    {
        $w = new WeichatBase;
        $config = $w->generateConfigParams();
        $env = [
            'wx_config'=> $w->generateConfigParams(
                Yii::$app->request->referrer),
            'baidu_map_key'=> Yii::$app->params['baidu.map.web_key'],
            ];
        $str = json_encode($env);
        if ($callback){
            header('Content-Type: application/javascript');
            echo $callback . "('" . $str . "')";
        } else {
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/json');
            echo $str;
        }
        exit();
    }

    public function actionAuth($return_page)
    {
        $params = [
            'origin_url' => Yii::$app->request->referrer,
            'callback_url' => $return_page,
        ];
        Yii::$app->session['wechat_state'] = $params;
        $callback = Url::to(['auth-end'], $scheme=true);
        $url = WechatUtils::makeAuthUrl($callback, $state='');
        return $this->redirect($url);
    }

    public function actionAuthEnd()
    {
        $code = Yii::$app->request->get('code');
        $params = Yii::$app->session['wechat_state'];
        if (!$code){
            throw new \yii\web\NotFoundHttpException();
        }

        $key = "wechat.authcode." . $code;
        $winfo = Yii::$app->cache->get($key);

        if (!$winfo){
            // 这里加cache 是因为用户网络环境不好，有可能重复发送请求，但code只能用一次
            $winfo = WechatUtils::getUserTokenByCode($code);
            //$token  = $winfo['access_token'];
            Yii::$app->cache->set($key, $winfo, 5 * 60);
        }
        $openid = $winfo['openid'];

        $record = WeichatUserInfo::find()->where(['openid'=>$openid])->one();
        if (!$record){
            $record = new WeichatUserInfo;

            $record->openid = $openid;
            $record->userid = 0;
            $record->is_receive_nearby_msg = 1; //接受微信推送消息
            $record->save();
        }
        $to = $params['callback_url'];
        $to .= '?origin_url=' . $params['origin_url'];
        if ($record->user){
            $user = $record->user;
            if (empty($user->access_token)) {
                $user->generateAccessToken();
                $user->save();
            }
            $userinfo = AUtils::formatProfile($user);
            $to .= '&user=' . urlencode(json_encode($userinfo));
        }
        $wechat = ['openid'=>$record->openid];
        $to .= '&wechat=' . urlencode(json_encode($wechat));
        return $this->redirect($to);
    }

}
