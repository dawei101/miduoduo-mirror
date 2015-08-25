<?php

namespace console\controllers;

use Yii;

class MiCacheController extends \yii\console\Controller
{

    public function actionClear($key, $domain='miduoduo')
    {
        $cache = Yii::$app->global_cache;
        $cache->keyPrefix = $domain;
        $cache->delete($key);
        echo "clear Done ! \n";
        return true;
    }

}
