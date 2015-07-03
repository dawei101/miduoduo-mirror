<?php
namespace m\controllers;

use Yii;
use yii\filters\AccessControl;
use m\MBaseController;

use common\models\Complaint;
use common\models\Task;

class ComplaintController extends MBaseController
{

    public $layout = 'main';

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
                        'actions' => ['create', 'edit', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' =>['view'],
                        'allow' => true,
                        'roles' => ['*'],
                    ],
                ],
            ],
        ];
    }

    public function actionCreate()
    {
        $model = new Complaint();
        $tgid = Yii::$app->request->get('gid');
        $task = $tgid?Task::find()->where(['gid'=> $tgid])->one():null;
        if (!$task){
            return $this->redirect404();
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/task/view', 'id' => $gid]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    protected function findModel($id)
    {
        if (($model = Address::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
