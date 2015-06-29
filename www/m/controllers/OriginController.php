<?php
namespace m\controllers;

use Yii;
use yii\web\HttpException;
use m\MBaseController;
use yii\helpers\FileHelper;

class OriginController extends MBaseController
{

    const VERSION_MARKER = '.version';

    public function getViewPath()
    {
        return Yii::getAlias('@m/web/html5-origin');
    }

    public function getClosestVersion($file, $version)
    {
        // do not use getViewPath to get view path, there is a bug!!!!!!!!!
        $path = Yii::getAlias('@m/web/html5-origin') . '/' . $file;
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
        return $v;
    }

    public function getViewFile($file, $v)
    {
        $tarr = explode('.', $file);
        $file = rtrim($file, '/');
        $file_suffix = count($tarr)>1?end($tarr):'html';
        if ($v>0){
            return $file . '/' . $v . '.' . $file_suffix;
        }
        return null;
    }

    public function actionHandle($version, $file='index')
    {
        $version = intval($version);
        $view = $this->getViewFile($file, $this->getClosestVersion($version));
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
 
