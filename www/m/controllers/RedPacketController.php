<?php

namespace m\controllers;

use yii;
use m\MBaseController;
use common\models\WeichatUserInfo;
use common\WeichatBase;
use common\models\LoginWithDynamicCodeForm;
use common\models\User;

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
            $invited = User::find()
                ->where(['invited_by'=>Yii::$app->user->id])
                ->with('resume')
                ->all();
            var_dump($invited);exit;
            echo $user_id.'<hr />'.$invited_count;
            exit;
        }else{
            $model = new LoginWithDynamicCodeForm();
            if( Yii::$app->request->ispost ){
                $data = Yii::$app->request->post();
                if( $model->load($data) && $model->login() ){
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