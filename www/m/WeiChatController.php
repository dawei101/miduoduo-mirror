<?php
namespace m;

use Yii;
use common\BaseController;
use yii\web\HttpException;

// 如果已经尝试获取过用户微信信息，则不执行任何操作，否则尝试获取用户微信信息
class WeiChatController extends BaseController{
    public $hasFetchWeichatID   = false;
    public $weichatState        = '';       // 微信跳转回来的带有参数
    public $appid               = '';
    public $secret              = '';
    public $scope               = '';

    public function __construct(){
        $this->appid   = Yii::$app->params['weichat']['appid'];
        $this->secret  = Yii::$app->params['weichat']['secret'];
        $this->scope   = Yii::$app->params['weichat']['scope1'];

        // 是否尝试过
        $this->hasFetchWeichatID    = Yii::$app->session->get('weichat')['hasFetchWeichatID'];
        // 是否是微信跳转回来的，如果是则会带上 state
        $this->weichatState         = Yii::$app->request->get('state');

        // if( !$this->hasFetchWeichatID ){
        if( !$this->hasFetchWeichatID ){
            if( $this->weichatState == 'fromweichatrequest' ){
                // 2. 获取用户微信信息
                $this->getWeichatInfoFetch();
            }else{
                // 1. 跳转到微信授权页面
                $this->getWeichatInfoJump();
            }
        }else{
            // 已经尝试获取过微信信息，则不在处理
            // print_r($_SESSION);exit;
        }
    }

    // 1. 跳转到微信授权页面
    public function getWeichatInfoJump(){
        // 通过微信接口获取微信信息
        $appid          = $this->appid;
        $scope          = $this->scope;
        // 构建跳回到到的地址
        $redirect_uri_real   = urlencode($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
        $redirect_uri   = urlencode('http://www.lianjievip.com/miduoduo/index.php?real='.$redirect_uri_real.'');
        $getCodeUrl     = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri='.$redirect_uri.'&response_type=code&scope='.$scope.'&state=fromweichatrequest#wechat_redirect';

        // 此处应该判断当前是否在微信浏览器中，如果不是，直接标记$weichatInfo['hasFetchWeichatID'] = true;保存到SESSION中，就不在继续了
        // 笨方法，获取上面地址的内容，看返回信息是否有“请在微信客户端打开链接”
        if( stripos(file_get_contents($getCodeUrl),'请在微信客户端打开链接') ){
            $weichatInfo    = array();
            // 标记已经获取过微信信息
            $weichatInfo['hasFetchWeichatID'] = true;
            // 经获取到的微信信息保存到SESSION
            Yii::$app->session->set('weichat',$weichatInfo);
        }else{  
            $this->redirect($getCodeUrl);
        }
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
        $getTokenJson   = file_get_contents($getTokenUrl);
        $getTokenArr    = json_decode($getTokenJson);

        // 用token 获取用户的微信id
        $token          = $getTokenArr->access_token;
        $openid         = $getTokenArr->openid;

        $weichatInfo    = array();
        if( $openid ){
            // 查询用户绑定信息，如果有，则自动登录

            // 如果没有，保存到SESSION，等注册或登录的时候，实现绑定
            $weichatInfo['openid']    = $openid;
        }

        // 标记已经获取过微信信息
        $weichatInfo['hasFetchWeichatID'] = true;
        // 经获取到的微信信息保存到SESSION
        Yii::$app->session->set('weichat',$weichatInfo);
        // print_r(Yii::$app->session);exit;
    }
}