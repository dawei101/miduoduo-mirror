<?php
namespace m;

use Yii;
use common\BaseController;
use yii\web\HttpException;
use common\models\WeichatUserInfo;

// 如果已经尝试获取过用户微信信息，则不执行任何操作，否则尝试获取用户微信信息
class WeiChatController extends BaseController{
    public $hasFetchWeichatID   = 0;        // 是否已经获取过微信ID
    public $weichatState        = '';       // 是否是微信跳转回来的，如果是则会带上 state
    public $isWeichatWeb        = 1;        // 是否是微信浏览器
    public $appid               = '';       // 微信公众好ID
    public $secret              = '';       // 微信secret
    public $scope               = '';       // 请求类型

    public function __construct(){
        $this->appid   = Yii::$app->params['weichat']['appid'];
        $this->secret  = Yii::$app->params['weichat']['secret'];
        $this->scope   = Yii::$app->params['weichat']['scope1'];
        $this->hasFetchWeichatID    = Yii::$app->session->get('weichat')['hasFetchWeichatID'] ? Yii::$app->session->get('weichat')['hasFetchWeichatID'] : 0;
        $this->weichatState         = Yii::$app->request->get('state') ? Yii::$app->request->get('state') : $this->weichatState;
        $this->isWeichatWeb         = $this->isWeichatWeb();

        if( $this->isWeichatWeb ){
            // 第一次进入，判断是否获取过微信ID
            if( !$this->hasFetchWeichatID ){
                if( $this->weichatState == 'fromweichatrequest' ){
                    // 2. 获取用户微信信息
                    $this->getWeichatInfoFetch();
                }else{
                    // 1. 跳转到微信授权页面
                    $this->getWeichatInfoJump();
                }
            // 已经尝试获取过微信信息，则不在处理
            }else{
                // 判断已登录用户，是否已经绑定微信
                // 如果SESSION里面有openid，并且用户登陆了，这里就去绑定
                $weichat= Yii::$app->session->get('weichat');
                $openid	= isset($weichat['openid']) ? $weichat['openid'] : 0;
                $userid	= Yii::$app->session->get('__id');
                $hasBindWeichatID	= isset($weichat['hasBindWeichatID']) ? $weichat['hasBindWeichatID'] : 0;

                // 标记渠道信息
                if( $openid ){
                    Yii::$app->session->set('origin','weichat');
                }

                if( $openid && $userid && !$hasBindWeichatID ){
                    // 绑定，保存数据库
                    if( $this->bindWeichatID($openid,$userid) ){
                        // 标记已经尝试过绑定
                        $weichatInfo	= Yii::$app->session->get('weichat');
                        $weichatInfo['hasBindWeichatID']	= 1;
                        Yii::$app->session->set('weichat',$weichatInfo);
                    }else{
                        // 绑定失败
                    }
                }else{
                    // 不作操作
                }
            }
        }
    }

    // 1. 跳转到微信授权页面
    public function getWeichatInfoJump(){
        // 通过微信接口获取微信信息
        $appid          = $this->appid;
        $scope          = $this->scope;
        
        // 构建跳回到到的地址
        $redirect_uri_real  = Yii::$app->params['baseurl.m'].$_SERVER['REQUEST_URI'];
        $redirect_uri       = urlencode($redirect_uri_real);
        $getCodeUrl         = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri='.$redirect_uri.'&response_type=code&scope='.$scope.'&state=fromweichatrequest#wechat_redirect';

        $this->redirect($getCodeUrl);
    }

    // 2. 获取用户微信信息
    public function getWeichatInfoFetch(){
        // 拿到微信返回的参数
        $code           = Yii::$app->request->get('code');
            
        // 获取access token
        $appid          = $this->appid;
        $secret         = $this->secret;
        $getTokenUrl    = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$appid.'&secret='.$secret.'&code='.$code.'&grant_type=authorization_code';
        // 请求接口
        $getTokenJson   = $this->getWeichatAPIdata($getTokenUrl);
        if( $getTokenJson != 'haserror' ){
            $getTokenArr    = json_decode($getTokenJson);

            // 用token 获取用户的微信id
            $token          = $getTokenArr->access_token;
            $openid         = $getTokenArr->openid;

            $weichatInfo    = array();
            if( $openid ){
                $this->loginByWeichatID($openid);
                $weichatInfo['openid']  = $openid;
            }
        }

        // 标记已经获取过微信信息
        $weichatInfo['hasFetchWeichatID'] = true;
        // 经获取到的微信信息保存到SESSION
        Yii::$app->session->set('weichat',$weichatInfo);
    }

	// 请求微信的接口数据
    private function getWeichatAPIdata($targetUrl){
        // 请求的数据
        $curlobj    = curl_init();
        curl_setopt($curlobj, CURLOPT_URL,$targetUrl);
        curl_setopt($curlobj, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlobj, CURLOPT_HEADER, 0);
        curl_setopt($curlobj, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curlobj, CURLOPT_SSL_VERIFYHOST, FALSE);
        $returnstr  = curl_exec($curlobj);
        if( curl_error($curlobj) ){
            $returnstr  = 'haserror';
        }
        curl_close($curlobj);
        
        return $returnstr;
    }

    // 通过微信id实现登录
    private function loginByWeichatID($openid){
        // 查询用户绑定信息，如果有，则自动登录
        $weichat_result = WeichatUserInfo::find()->where(['openid'=>$openid])->one();
        if( $weichat_result ){
            Yii::$app->session->set('__id',$weichat_result->userid);
            // 更新登录时间
            $datetime       = date("Y-m-d H:i:s",time());
            $weichat_result->updated_time = $datetime;
            $weichat_result->save();
        }
        // 将微信id保存到session,用户登陆后自动绑定
        $weichatInfo['openid']    = $openid;
    }
    
    // 获取过微信账号、登录后--绑定微信账号
	private function bindWeichatID($openid,$userid){
		// 判断是否已经绑定
        $weichat_result = WeichatUserInfo::find()->where(['userid'=>$userid])->one();
        if( !$weichat_result ){
            $datetime       = date("Y-m-d H:i:s",time());
            // 插入数据，完成绑定
            $weichat    = new WeichatUserInfo();
            $weichat->openid    = $openid;
            $weichat->userid    = $userid;
            $weichat->created_time    = $datetime;
            $weichat->updated_time    = $datetime;
            $weichat->is_receive_nearby_msg = 1;    // 新绑定的用户，默认接受微信推送消息
            $weichat->save();
        }
        return true;
	}

    // 判断是否是微信浏览器
    // 这个方法在IOS正常使用
    private function isWeichatWeb(){ 
	if ( stripos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
			return 1;
	}	
	return 0;
}
}