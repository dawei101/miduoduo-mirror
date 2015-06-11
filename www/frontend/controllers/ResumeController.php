<?php
namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;

use common\models\Resume;
use common\models\Freetime;

use frontend\FBaseController;
use frontend\models\EditResumeForm;

class ResumeController extends FBaseController
{
     /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['edit', 'freetimes'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['edit01'],
                        'allow' => true,
                    ],
                ],
            ],
        ];
    }


    public function actionEdit01()
    {
        return $this->redirect(Yii::$app->params['baseurl.m']);
        $user = Yii::$app->user;
        $resume = Resume::findOne(['user_id'=>$user->id]);
        if (!$resume){
            $resume = new Resume();
            $resume->user_id = $user->id; 
            $resume->is_student = true; 
            $resume->phonenum = $user->identity->username;
            $resume->save();
        }

        $model = new EditResumeForm($resume);

        $freetimes = Freetime::findAll(['user_id'=>Yii::$app->user->id]);
        $freetimes_dict = [];
        foreach($freetimes as $freetime){
            $freetimes_dict[$freetime->dayofweek] = $freetime;
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->render('edit01_done', [
                'model' => $model,
            ]);

        } else {
            return $this->render('edit01', [
                'model' => $model,
                'freetimes' => $freetimes_dict
            ]);
        }
    }

    public function actionFreetimes()
    {
        if (Yii::$app->request->isPost){
            $dayofweek = intval(Yii::$app->request->post('dayofweek'));
            $when = Yii::$app->request->post('when');
            $is_availiable = filter_var(
                Yii::$app->request->post('is_availiable'),
                FILTER_VALIDATE_BOOLEAN);
            if ($this->setFreetime(Yii::$app->user->id, $dayofweek, $when, $is_availiable)){
                $this->renderJson([
                    'result'=> true,
                    'is_availiable'=> $is_availiable
                ]);
            } else {
                $this->renderJson([
                    'result'=> false,
                ]);
            }
        }
        $freetimes = Freetime::findAll(['user_id'=>Yii::$app->user->id]);
        $freetimes_dict = [];
        foreach($freetimes as $freetime){
            $freetimes_dict[$freetime->dayofweek] = $freetime;
        }
        return $this->render('freetimes', ['freetimes' => $freetimes_dict]);
    }

    protected function setFreetime($user_id, $dayofweek, $when, $is_availiable)
    {
        $freetime = Freetime::findOne(['user_id'=>$user_id, 'dayofweek'=>$dayofweek]);
        if (!$freetime){
            $freetime = new Freetime();
            $freetime->dayofweek = $dayofweek;
            $freetime->user_id = $user_id;
            $freetime->$when = $is_availiable;
        } else {
            $freetime->$when = $is_availiable;
        }
        if (!$freetime->hasErrors()){
            $freetime->save();
            return true;
        }
        return false;
    }
}
