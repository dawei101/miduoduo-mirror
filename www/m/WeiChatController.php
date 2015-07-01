<?php
namespace m;

use Yii;
use common\BaseController;
use yii\web\HttpException;

// ����Ѿ����Ի�ȡ���û�΢����Ϣ����ִ���κβ����������Ի�ȡ�û�΢����Ϣ
class WeiChatController extends BaseController{
    public $hasFetchWeichatID   = false;
    public $weichatState        = '';       // ΢����ת�����Ĵ��в���
    public $appid               = '';
    public $secret              = '';
    public $scope               = '';

    public function __construct(){
        $this->appid   = Yii::$app->params['weichat']['appid'];
        $this->secret  = Yii::$app->params['weichat']['secret'];
        $this->scope   = Yii::$app->params['weichat']['scope1'];

        // �Ƿ��Թ�
        $this->hasFetchWeichatID    = Yii::$app->session->get('weichat')['hasFetchWeichatID'];
        // �Ƿ���΢����ת�����ģ������������ state
        $this->weichatState         = Yii::$app->request->get('state');

        // if( !$this->hasFetchWeichatID ){
        if( !$this->hasFetchWeichatID ){
            if( $this->weichatState == 'fromweichatrequest' ){
                // 2. ��ȡ�û�΢����Ϣ
                $this->getWeichatInfoFetch();
            }else{
                // 1. ��ת��΢����Ȩҳ��
                $this->getWeichatInfoJump();
            }
        }else{
            // �Ѿ����Ի�ȡ��΢����Ϣ�����ڴ���
            // print_r($_SESSION);exit;
        }
    }

    // 1. ��ת��΢����Ȩҳ��
    public function getWeichatInfoJump(){
        // ͨ��΢�Žӿڻ�ȡ΢����Ϣ
        $appid          = $this->appid;
        $scope          = $this->scope;
        // �������ص����ĵ�ַ
        $redirect_uri_real   = urlencode($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
        $redirect_uri   = urlencode('http://www.lianjievip.com/miduoduo/index.php?real='.$redirect_uri_real.'');
        $getCodeUrl     = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri='.$redirect_uri.'&response_type=code&scope='.$scope.'&state=fromweichatrequest#wechat_redirect';

        // �˴�Ӧ���жϵ�ǰ�Ƿ���΢��������У�������ǣ�ֱ�ӱ��$weichatInfo['hasFetchWeichatID'] = true;���浽SESSION�У��Ͳ��ڼ�����
        // ����������ȡ�����ַ�����ݣ���������Ϣ�Ƿ��С�����΢�ſͻ��˴����ӡ�
        if( stripos(file_get_contents($getCodeUrl),'����΢�ſͻ��˴�����') ){
            $weichatInfo    = array();
            // ����Ѿ���ȡ��΢����Ϣ
            $weichatInfo['hasFetchWeichatID'] = true;
            // ����ȡ����΢����Ϣ���浽SESSION
            Yii::$app->session->set('weichat',$weichatInfo);
        }else{  
            $this->redirect($getCodeUrl);
        }
    }

    // 2. ��ȡ�û�΢����Ϣ
    public function getWeichatInfoFetch(){
        // �õ�΢�ŷ��صĲ���
        $code           = Yii::$app->request->get('code');

        // ��ȡaccess token
        $appid          = $this->appid;
        $secret         = $this->secret;
        $getTokenUrl    = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$appid.'&secret='.$secret.'&code='.$code.'&grant_type=authorization_code';
        // ����ӿ�
        $getTokenJson   = file_get_contents($getTokenUrl);
        $getTokenArr    = json_decode($getTokenJson);

        // ��token ��ȡ�û���΢��id
        $token          = $getTokenArr->access_token;
        $openid         = $getTokenArr->openid;

        $weichatInfo    = array();
        if( $openid ){
            // ��ѯ�û�����Ϣ������У����Զ���¼

            // ���û�У����浽SESSION����ע����¼��ʱ��ʵ�ְ�
            $weichatInfo['openid']    = $openid;
        }

        // ����Ѿ���ȡ��΢����Ϣ
        $weichatInfo['hasFetchWeichatID'] = true;
        // ����ȡ����΢����Ϣ���浽SESSION
        Yii::$app->session->set('weichat',$weichatInfo);
        // print_r(Yii::$app->session);exit;
    }
}