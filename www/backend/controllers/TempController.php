<?php

namespace backend\controllers;

use Yii;
use backend\BBaseController;
use common\models\WeichatUserInfo;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use common\WeichatBase;

/**
 * UserController implements the CRUD actions for User model.
 */
class TempController extends BBaseController
{
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['delete-myself'],
                        'allow' => true,
                        'roles' => ['developer'],
                    ],
                ],
            ],
        ]);
    }

    public function actionIndex(){
        $user   = WeichatUserInfo::find()->orderby(['id'=>SORT_ASC])->all();
        $wb = new WeichatBase();
        $at = $wb->getWeichatAccessToken();

        foreach( $user as $k => $v ){
            $api = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$at."&openid=".$v->openid;
            $data = $wb->getWeichatAPIdata($api);
            $data = json_decode($data);
            if( !isset($data->errcode) ){
                $openid = isset($data->openid) ? $data->openid : '';
                $unionid= isset($data->unionid) ? $data->unionid : '';
                if($openid && $unionid){
                    // 更新
                    WeichatUserInfo::updateAll(['unionid'=>$unionid],['openid'=>$openid]);
                }else{
                    echo $v->openid;
                    echo '<br />';
                }
                
            }else{
                echo $v->openid;
                echo '<br />';
            }
            
        }
    }
}
