<?php
namespace frontend\controllers;

use Yii;
use yii\web\HttpException;
use yii\filters\AccessControl;

use common\models\Resume;
use common\models\User;

use frontend\FBaseController;

class ResumeController extends FBaseController
{

    public function actionDetail($user_id){
        $resume   = User::find()->where(['id'=>$user_id])
            ->with('resume')
            ->with('applicantDone')
            ->one();
        if (!$resume){
            throw new HttpException(404, 'Resume not found');
        }
        $this->layout   = false;

        return $this->render(
            'detail',['resume'=> $resume]  
        );
    }
}
