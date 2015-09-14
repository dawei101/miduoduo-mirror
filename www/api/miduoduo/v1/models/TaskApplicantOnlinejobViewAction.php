<?php

namespace api\miduoduo\v1\models;

use Yii;

use common\models\TaskApplicantOnlinejob;


class TaskApplicantOnlinejobViewAction extends \yii\rest\ViewAction
{

    public function run($id)
    {
        $model = $this->findModel($id);
        $model->needinfo = unserialize($model->needinfo);
        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id, $model);
        }
        return $model;
    }

}
