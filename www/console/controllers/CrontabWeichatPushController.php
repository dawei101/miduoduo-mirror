<?php
/**
 */

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\console\Exception;
use common\pusher\WechatPusher;
use common\models\WeichatPushSetPushset;
use common\models\WeichatPushSetTemplatePushList;
use common\models\WeichatUserInfo;

class CrontabWeichatPushController extends Controller
{
    /**
     * @var string controller default action ID.
     */
    public $defaultAction = 'index';

    public function actionIndex(){
        echo 'test';
    }

    /**
     *
     * actionNerabyTaks 最新附近兼职微信消息推送
     *
     * @author suixb
     * @param int $pushid 使用的推送设置
     * @return boolean 执行完成情况
     *
     */
    public function actionNearbyTaks($pushtime=1){
        // 根据pushtime 查询这次需要推送的消息
        $pushid_arr     = WeichatPushSetPushset::find()->where(['push_time'=>$pushtime])->asArray()->one();
        $pushid         = $pushid_arr['id'];

        // 根据$pushid 查询对应的消息模板
        $pushset        = new WeichatPushSetPushset();
        $pushset_arr    = $pushset->find()->where(['id'=>$pushid])->asArray()->one();
        $pushtemp_id    = $pushset_arr['template_push_id'];
        if( $pushtemp_id ){
            $pushtemp       = new WeichatPushSetTemplatePushList();
            $pushtemp_arr   = $pushtemp->find()->where(['id'=>$pushtemp_id])->asArray()->one();
        }
        
        if($pushtemp_arr['title']){
            $params         = array(
                array('name'=>'keyword1','value'=>$pushtemp_arr['title'],'color'=>'#0000FE'), 
                array('name'=>'keyword2','value'=>'实时通知','color'=>'#222'), 
            );

            $gotoUrl        = Yii::$app->params['baseurl.m'].'/task/nearby?id='.$pushtemp_arr['id'];

            // 得到待推送的用户列表
            // 这里只给 is_receive_nearby_msg=1 的用户发送推送
            $userlist       = WeichatUserInfo::find()->where(['is_receive_nearby_msg'=>1])->asArray()->all();

            // 本次推送的分组标识
            $pushGroup      = uniqid();

            // 此处需要优化，如果发送2W条，使用 长连接？分组方式？
            if( count($userlist) ){
                $pusher = new WechatPusher();
                foreach( $userlist as $key => $value ){
                    $pusher->pushWeichatMsg(
                        $value['openid'],
                        'qwENcjpEuIBn53LHyFh4-PmmpVaSmL04WpylDX1JkaE',
                        $params,
                        $gotoUrl,
                        $pushGroup
                    );
                }

                // 推送完毕，更新推送的设置信息
                $quality    = WeichatPushSetPushset::findOne($pushid);
                $quality->latest_push_time      = date("Y-m-d H:i:s",time());
                $quality->latest_push_group     = $pushGroup;
                $quality->update();
            }
        }
    }
}

