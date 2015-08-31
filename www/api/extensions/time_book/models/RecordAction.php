<?php
namespace api\extensions\time_book\models;

use Yii;


class RecordAction extends \yii\rest\CreateAction
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
        $req = Yii::$app->getRequest();
        $params = $req->getBodyParams();
        $schedule = null;
        if ($req->post('schedule_id')){
            $schedule = Schedule::findOne($params['schedule_id']);
        }
        if (!$schedule){
            unset($params['schedule_id']);
        } else {
            $params['owner_id'] = $schedule->owner_id;
        }
        $mtime = (strtotime($schedule->from_datetime) + strtotime($schedule->to_datetime))/2;

        if (time()>$mtime){
            $params['event_type'] = $model::EVENT_OFF;
        } else {
            $params['event_type'] = $model::EVENT_ON;
            $on_model = $this->modelClass::findOne(
                ['schedule_id'=>$schedule->id, 'event_type'=>$model::EVENT_ON]);
            if ($on_model){
                $params['event_type'] = $model::EVENT_WORKING;
            }
        }

        $model->load($params, '');
        if ($model->save()) {
            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);
            $model->save();
            $model->checkout();
            if ($model->event_type==$model::EVENT_OFF){
                $this->modelClass::updateAll(
                    ['event_type'=>$model::EVENT_WORKING],
                    ['schedule_id'=>$schedule->id, 'event_type'=>$model::EVENT_OFF]
                );
            }
        } elseif (!$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }
        return $model;
    }

}
