<?php

namespace console\controllers;

use yii\console\Controller;

class JobController extends Controller
{

    public function actionSyncFileToCloudStorage($model, $column, $pk)
    {
        $obj = $mdoel::findOne($pk);
        if (!$obj){
            return false;
        }
        $path = Yii::getAlias('@media/' . $obj->$column);

    }
}
