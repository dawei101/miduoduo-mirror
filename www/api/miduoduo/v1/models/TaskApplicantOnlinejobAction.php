<?php

namespace api\miduoduo\v1\models;

use Yii;

use common\models\TaskApplicantOnlinejob;


class TaskApplicantOnlinejobAction extends \yii\rest\CreateAction
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

        $needinfo_arr = [];
        foreach( $data as $k => $v ){
            if( is_numeric($k) ){
                $needinfo_arr[$k] = $v;
                unset($data[$k]);
            }
        }
        $data['needinfo'] = serialize($needinfo_arr);

        $model->load($data, '');
        
        if ($model->save()) {
            
        } elseif (!$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }

        return $model;
    }

}
