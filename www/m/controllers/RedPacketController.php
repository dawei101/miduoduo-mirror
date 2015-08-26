<?php

namespace m\controllers;

use yii;
use m\MBaseController;
use common\models\WeichatUserInfo;
use common\WeichatBase;
use common\models\LoginWithDynamicCodeForm;

class RedPacketController extends MBaseController
{
    public function actionIndex($user_id='2006'){
        $weichat_user = WeichatUserInfo::find()
            ->where(['userid'=>$user_id])
            ->with('resume')
            ->one();
        $weichat_base = new WeichatBase();

        if( !$weichat_base->checkErweimaValid($weichat_user->erweima_date) ){
            $erweima_ticket = $weichat_base->createErweimaByUserid($user_id);
        }else{
            $erweima_ticket = $weichat_user->erweima_ticket;
        }

        $this->layout = false;
        return $this->render(
            'index',
            [
                'weichat_user' => $weichat_user,
                'erweima_ticket' => $erweima_ticket,
            ]
        );
    }

    public function actionMy(){
        $user_id = Yii::$app->user->id;
        if( $user_id ){
            echo $user_id;
            exit;
        }else{
            $model = new LoginWithDynamicCodeForm();
            if( Yii::$app->request->ispost ){
                if( $model->load(Yii::$app->request->post()) && $model->login() ){
                    $this->redirect("my");
                }
            }
            return $this->render(
                'vlogin',   
                [
                    'model' => $model,
                ]
            );
        }
        exit;
    }
}

?>