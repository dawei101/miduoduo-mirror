<?php
namespace corp\controllers;

use Yii;
use corp\CBaseController;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;


/**
 * Site controller
 */
class TimeBookController extends CBaseController
{

    public function actionIndex()
    {
        if (\Yii::$app->user->isGuest) {
            return $this -> render('index');
        }
        return $this->redirect('/task/');
    }

}
