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
        $params['event_type'] = $req->post('action')=='off'?
            $model::EVENT_OFF:$model::EVENT_ON;
        $model->load($params, '');
        if ($model->save()) {
            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);
            $model->owner_id = $schedule->owner_id;

            $model->save();

        } elseif (!$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }

        return $model;
    }

}
