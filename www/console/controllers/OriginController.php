<?php
/**
 */

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\console\Exception;
use \common\models\User;

class OriginController extends Controller
{

    public $defaultAction = 'current-version';

    public function getMarkFile()
    {
        return \m\controllers\OriginController::getViewPath() . '/.version';
    }

    public function getCurrentVersion()
    {
        $content = file_get_contents($this->getMarkFile());
        return intval(end(explode("\n", $content)));
    }

    public function markVersion($version)
    {
        $version = intval($version);
        $cr = $this->getCurrentVersion();
        if ($version<$cr) {
            die('version could not low than ' .$cr);
        }
        $f = fopen($this->getMarkFile(), "a");
        fwrite($f, "\n" . $version);
        fclose($f);
    }

    public function actionCurrentVersion()
    {
        echo "Current html5 origin version is:  " . $this->getCurrentVersion();
        echo "\n";
    }

    public function actionUpVersion()
    {
        $this->markVersion($this->getCurrentVersion()+1);
        $this->actionCurrentVersion();
    }

    public function actionImportSource($path)
    {
        
    }

    public function actionExportSource($path, $version=null)
    {

    }
}
