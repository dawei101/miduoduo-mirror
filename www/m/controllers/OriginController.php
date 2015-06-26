<?php
namespace m\controllers;

use Yii;
use yii\web\HttpException;
use m\MBaseController;


class OriginController extends MBaseController
{

    public function getViewFile($path, $version)
    {
        $path = Yii::getAlias('@m/views/origin/' . $path);
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
            return $path . '/' . $v . '.php';
        }
        return null;
    }

    public function actionHandle($version, $file='index')
    {
        $version = intval($version);
        $view = $this->getViewFile($path, $version);
        if (!$view){
            throw new HttpException(404, 'File not found');
        }
        return $this->renderPartial($view);
    }
}
 
