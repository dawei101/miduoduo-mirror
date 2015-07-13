<?php
namespace m\controllers;

use m\MBaseController;
use Yii;
use common\models\WeichatErweima;
use common\models\WeichatErweimaLog;
use common\WeichatBase;

class WeichatController extends MBaseController{
    public function actionIndex(){
        // 第一次接入微信，做验证
        if( Yii::$app->request->get("echostr") ){
            echo Yii::$app->request->get("echostr");
            exit;
        }
        $this->responseMsg();
    }

    private function responseMsg(){
		// get post data, May be due to the different environments
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

      	// extract post data
		if (!empty($postStr)){
                libxml_disable_entity_loader(true);
              	$postObj        = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                $fromUsername   = $postObj->FromUserName;   // 微信用户ID
                $toUsername     = $postObj->ToUserName;     // 开发者账号
                $keyword        = trim($postObj->Content);  // 用户输入信息
                $time           = $postObj->CreateTime;     // 请求时间
                $msgtype        = $postObj->MsgType;        // 请求类型
                $event          = $postObj->Event ? $postObj->Event : '';   // 事件类型

                $re_contentStr  = '';                       // 返回消息
                $re_time        = time();                   // 返回时间
                $re_msgType     = "text";                   // 返回消息类型
                // 返回消息模板
                $re_textTpl     = "
                                <xml>
							    <ToUserName><![CDATA[%s]]></ToUserName>
                                <FromUserName><![CDATA[%s]]></FromUserName>
                                <CreateTime>%s</CreateTime>
                                <MsgType><![CDATA[%s]]></MsgType>
                                <Content><![CDATA[%s]]></Content>
                                <FuncFlag>0</FuncFlag>
                                </xml>
                "; 

                // 创建对象：用户微信行为
                $WeichatErweimaLog  = new WeichatBase();

                // 如果是消息类型
                if( $msgtype == 'text' ){
                    if(!empty( $keyword )){
                        $re_contentStr = "直接查看北京最新兼职，点击http://m.miduoduo.cn/task \n其他问题在输入框直接填写，米小多会即时回复您。找不到想找的兼职，也回复给我们吧！";
                    }else{
                        $re_contentStr = "Input something...";
                    }
                // 如果是事件类型
                }else{
                    // 如果是扫描二维码，之前用户已关注
                    if( $event == 'SCAN' ){
                        // 获取二维码的返回值
                        $Ticket   = $postObj->Ticket ? $postObj->Ticket : '';
                        $re_contentStr  = $this->getReturnMsgByTicket($Ticket,$fromUsername,0);
                    // 如果是扫描二维码，之前用户未关注
                    }elseif( $event == 'subscribe' ){
                        // 获取二维码的返回值
                        $Ticket   = $postObj->Ticket ? $postObj->Ticket : '';
                        if( $Ticket ){
                            $re_contentStr  = $this->getReturnMsgByTicket($Ticket,$fromUsername,1);
                        }else{
                           // 单纯的关注事件
                           $re_contentStr  = "感谢您关注米多多！ \n点击下面的链接即可快速进行注册：http://m.miduoduo.cn/user/vsignup"; 
                            // 保存数据
                            if($fromUsername){
                                $WeichatErweimaLog->saveEventLog($fromUsername,1);  // 1表示关注事件
                            }
                        }
                    // 取消关注事件
                    }elseif( $event == 'unsubscribe' ){
                        // 保存数据
                        if($fromUsername){
                            $WeichatErweimaLog->saveEventLog($fromUsername,2);  // 2表示取消关注事件
                        }
                    }else{
                        $re_contentStr  = "感谢您关注米多多！ \n点击下面的链接即可快速进行注册：http://m.miduoduo.cn/user/vsignup";
                    }
                }
                $resultStr = sprintf($re_textTpl, $fromUsername, $toUsername, $re_time, $re_msgType, $re_contentStr);
                echo $resultStr;
        }else {
            // 没有POST参数过来
        	echo "access denied";
        	exit;
        }
        
    }

    // 通过扫描二维码返回的ticket，找到需要返回的内容，并记录扫描日志
    public function getReturnMsgByTicket($ticket,$openid,$isNew=0){
        // 通过ticket查找返回信息
        $erweima    = WeichatErweima::find()->where(['ticket'=>$ticket])->asArray()->one();
        $reMsg      = $erweima['after_msg'] ? $erweima['after_msg'] : '直接查看北京最新兼职，点击http://m.miduoduo.cn/task \n其他问题在输入框直接填写，米小多会即时回复您。找不到想找的兼职，也回复给我们吧';

        // 保存用户扫描记录
        if( isset($erweima['id']) ){
            $erweilog   = new WeichatErweimaLog();
            $erweilog->erweima_id       = $erweima['id'];
            $erweilog->openid           = (string)$openid;
            $erweilog->create_time      = date("Y-m-d H:i:s",time());
            $erweilog->has_bind         = 0;
            $erweilog->follow_by_scan   = $isNew;
            $erweilogsave               = $erweilog->save();
        }

        return $reMsg;
    }


}