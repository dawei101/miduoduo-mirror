<?php

namespace console\jobs;

use console\BaseJob;

class CouldStorageJob extends BaseJob
{

    public function actionSyncFile($model, $column, $pk)
    {
        $obj = $mdoel::findOne($pk);
        if (!$obj){
            return false;
        }
        $path = Yii::getAlias('@media/' . $obj->$column);
        //upload to aliyun
        $obj->$column = $http_path;
        $obj->save();
        return true;
    }
}
