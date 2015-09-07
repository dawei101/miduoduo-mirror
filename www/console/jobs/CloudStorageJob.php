<?php

namespace console\jobs;

use console\BaseJob;

class CloudStorageJob extends BaseJob
{

    public function actionSyncFile($model, $column, $pk)
    {
        $obj = $mdoel::findOne($pk);
        if (!$obj){
            return false;
        }
        $path = Yii::getAlias('@media/' . $obj->{$column});
        Yii::$app->cloud_storage->uploadFile($path, 'media/' . $obj->{$column});
        //upload to aliyun
        $http_path = 'http://alimedia.miduoduo.cn/media/' . $obj->{$column};
        $obj->$column = $http_path;
        return $obj->save();
    }
}
