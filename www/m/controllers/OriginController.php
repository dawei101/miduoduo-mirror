<?php
namespace m\controllers;

use Yii;
use m\MBaseController;


class OriginController extends MBaseController
{

    public function getViewFile($action, $version)
    {
        $path = Yii::getAlias('@m/views/origin/' . $action);
        if (!file_exists($path)){
            return null;
        }
        $v = 0;
        foreach (scandir($path, SCANDIR_SORT_DESCENDING) as $f){
            $cv = intval(current(explode('.', $f)));
            if ($cv>0 && $cv<=$version && $cv>$v){
                $v = $cv;
            }
        }
        if ($v>0){
            return $action . '/' . $v . '.php';
        }
        return null;
    }

    public function actionHandle($version, $action='index')
    {
        $version = intval($version);
        $view = $this->getViewFile($action, $version);
        return $this->renderPartial($view);
    }
}
 
