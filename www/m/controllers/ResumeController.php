<?php
namespace m\controllers;

use Yii;
use yii\filters\AccessControl;

use common\models\Resume;
use common\models\Freetime;

use m\MBaseController;
use m\models\EditResumeForm;

class ResumeController extends MBaseController
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
                        'actions' => ['edit', 'edit01', 'freetimes'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }


    public function actionEdit01()
    {
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('/resume/freetimes');
        } else {
            return $this->render('edit01', [
                'model' => $model,
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
