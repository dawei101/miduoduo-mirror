<?php
namespace m\controllers;

use Yii;
use yii\web\HttpException;
use m\MBaseController;
use yii\helpers\FileHelper;

class OriginController extends MBaseController
{

    public function getViewPath()
    {
        return Yii::getAlias('@m/html5-origin');
    }

    public function getViewFile($file, $version)
    {
        $path = $this->getViewPath() . '/' . $file;
        if (!file_exists($path)){
            return null;
        }
        // 是文件直接返回
        if (is_file($path)){
            return $file;
        }
        $tarr = explode('.', $file);
        $file_suffix = count($tarr)>1?end($tarr):'php';

        $v = 0;
        foreach (scandir($path, SCANDIR_SORT_DESCENDING) as $f){
            $cv = intval(current(explode('.', $f)));
            if ($cv>0 && $cv<=$version && $cv>$v){
                $v = $cv;
            }
        }
        if ($v>0){
            return $file . '/' . $v . '.' . $file_suffix;
        }
        return null;
    }

    public function actionHandle($version, $file='index')
    {
        $version = intval($version);
        $view = $this->getViewFile($file, $version);
        if (!$view){
            throw new HttpException(404, 'File not found');
        }
        $this->setMimeType($view);
        return $this->renderPartial($view);
    }

    public function setMimeType($view)
    {
        $mime_type = FileHelper::getMimeTypeByExtension($view);
         Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        $headers = Yii::$app->response->headers;
        $headers->add('Content-Type', $mime_type);
    }
}
 
