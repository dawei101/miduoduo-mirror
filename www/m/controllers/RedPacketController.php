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
    public function actionIndex($id='2006'){
        $user_id = $id;
        $weichat_user = WeichatUserInfo::find()
            ->where(['userid'=>$id])
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
            $inviteds = User::find()
                ->where(['invited_by'=>Yii::$app->user->id])
                ->limit(5)
                ->all();
            $invited_all = User::find()
                ->where(['invited_by'=>Yii::$app->user->id])
                ->count();
            
            $this->layout = false;
            return $this->render(
                'my',
                [
                    'inviteds' => $inviteds,
                    'user_id' => $user_id,
                    'invited_all' => $invited_all,
                ]
            );
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

    public function actionMyRecords(){
        $user_id = Yii::$app->user->id;
        if( $user_id ){
            $inviteds = User::find()
                ->where(['invited_by'=>Yii::$app->user->id])
                ->limit(100)
                ->all();
            $invited_all = User::find()
                ->where(['invited_by'=>Yii::$app->user->id])
                ->count();
            
            $this->layout = false;
            return $this->render(
                'my-records',
                [
                    'inviteds' => $inviteds,
                    'user_id' => $user_id,
                    'invited_all' => $invited_all,
                ]
            );
        }
    }
}

?>