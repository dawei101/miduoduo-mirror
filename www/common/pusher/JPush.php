<?php

namespace common\pusher;

use Yii;

require_once(Yii::getAlias('@vendor/autoload.php'));

use JPush\Model as JModel;
use JPush\JPushClient;
use JPush\Exception\APIConnectionException;
use JPush\Exception\APIRequestException;

use common\constants;

use common\models\Authentification;


class JPush
{

    private $_client;

    public $app_key;
    public $master_secret;


    public function getClient()
    {
        if (empty($this->app_key) || empty($this->master_secret)){
            throw new Exception('Need to set <app_key> and <master_secret> in your  main config');
        }
        if (empty($this->_client)) {
            $this->_client = new JPushClient($this->app_key, $this->master_secret);
        }
        return $this->_client;
    }

    public function pushNotification($user_id, $message, $devices=null)
    {
        $auths = Authentification::find()->where(['user_id'=>$user_id])->all();
        $reg_ids = [];
        foreach ($auths as $auth){
            if ($auth->access_token && 0<strlen($auth->access_token)){
                $reg_ids[] = $auth->reg_id;
            }
        }
        if (empty($reg_ids)){
            Yii::error("Push failed, No signed in device for this user ");
            return false;
        }
        $audiences = JModel\audience(JModel\registration_id($reg_ids));
        try {
            $result = $this->getClient()
                ->push()
                ->setPlatform(JModel\all)
                ->setAudience($audiences)
                ->setNotification(JModel\notification($message))
                ->send();
            Yii::trace('Push message succeed with sendno:'. $result->sendno
                . ', message id:' . $result->msg_id
            );
        } catch (APIRequestException $e) {
            Yii::error('Push failed with code:' . $e->code . ', message:'. $e->message . ', json response: '. $e->json);
            return false;
        } catch (APIConnectionException $e) {
            Yii::error('Push failed with connection error:' . $e->getMessage());
            return false;
        }
        return true;
    }

    public function pushMessage($user_id, $message, $devices=null){

    }
}
