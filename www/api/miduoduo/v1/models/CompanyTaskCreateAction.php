<?php

namespace api\miduoduo\v1\models;

use Yii;
use yii\base\Model;
use yii\helpers\Url;
use yii\web\ServerErrorHttpException;
use common\models\TaskAddress;
use common\models\Task;

class CompanyTaskCreateAction extends \yii\rest\CreateAction
{

    public function run()
    {
        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id);
        }
        /* @var $model \yii\db\ActiveRecord */
        $model = new $this->modelClass([
            'scenario' => $this->scenario,
        ]);
        $data = Yii::$app->getRequest()->getBodyParams();

        if( isset($data['is_longterm']) && $data['is_longterm'] == 1 ){
            $data['from_date'] = '2015-01-01';
            $data['to_date'] = '2115-01-01';
        }
        if( isset($data['is_allday']) && $data['is_allday'] == 1 ){
            $data['from_time'] = '00:00';
            $data['to_time'] = '23:59';
        }
        $check_input_data_msg = Task::checkInputData($data);
        if( $check_input_data_msg ){
            return [
                'success' => false,
                'message' => $check_input_data_msg,
            ];
        }

        $model->load($data, '');
        if ($model->save()) {
            $address_ids = isset($data['address_ids']) ? $data['address_ids'] : '';
            if($address_ids){
                $task_id = $model->id;
                $addressList = explode(',', $address_ids);
                foreach($addressList as $item){
                    $address = TaskAddress::findOne(['id' => $item]);
                    if( isset($address->task_id) ){
                        $address->task_id = $task_id;
                        $address->save();
                    }
                }
            }

            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);
            $id = implode(',', array_values($model->getPrimaryKey(true)));
            $response->getHeaders()->set('Location', Url::toRoute([$this->viewAction, 'id' => $id], true));
        } elseif (!$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }
        return $model;
    }

}