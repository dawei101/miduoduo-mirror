<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\data\Pagination;
use yii\filters\VerbFilter;
use yii\web\HttpException;

use common\controllers\BaseController;
use common\models\LoginForm;
use common\models\Resume;
use common\models\Freetime;

use backend\models\EditResumeForm;

/**
 * Resume controller
 */
class ResumeController extends BaseController
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
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['index', 'edit', 'add', 'freetimes'],
                        'allow' => true,
                        'roles' => ['admin' , 'hunter'],
                    ],

                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        $query = Resume::find()->where(['status' => 0]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('index', [
             'models' => $models,
             'pages' => $pages,
        ]);
    }

    public function actionEdit()
    {
        $user_id = intval(Yii::$app->request->get('user_id'));
        if ($user_id){
            $resume = Resume::findOne(['user_id'=>$user_id]);
            if ($resume){
                $model = new EditResumeForm($resume);
                if ($model->load(Yii::$app->request->post()) && $model->save()) {
                    return $this->redirect('/resume/freetimes?user_id=' . $user_id);
                } else {
                    return $this->render('edit', [
                        'model' => $model,
                    ]);
                }
            }
        }
        throw new HttpException(404, '未知的用户简历');
    }

    public function actionAdd()
    {
        $user_id = intval(Yii::$app->request->get('user_id'));
        if (!$user_id){
            throw new HttpException(404, '未知的用户信息');
        }
        return $this->render('add');
    }

    public function actionFreetimes()
    {
        $user_id = intval(Yii::$app->request->get('user_id'));
        if (!$user_id){
            throw new HttpException(404, '未知的用户信息');
        }
        if (Yii::$app->request->isPost){
            $dayofweek = intval(Yii::$app->request->post('dayofweek'));
            $when = Yii::$app->request->post('when');
            $is_availiable = filter_var(
                Yii::$app->request->post('is_availiable'),
                FILTER_VALIDATE_BOOLEAN);
            if ($this->setFreetime($user_id, $dayofweek, $when, $is_availiable)){
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
        $freetimes = Freetime::findAll(['user_id'=>$user_id]);
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
