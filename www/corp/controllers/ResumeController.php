<?php
namespace corp\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use corp\FBaseController;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\db\Query;
use yii\data\Pagination;

use common\models\TaskApplicant;


/**
 * Site controller
 */
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
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                    'login' => ['post'],
                    'register' => ['post'],
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
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function findByCorpUserId($corpUserId)
    {
        $query = new Query;
        $query ->select([
            'jz_task_applicant.id',
            'jz_task_applicant.created_time',
            'jz_resume.name',
            'TIMESTAMPDIFF(YEAR, jz_resume.birthdate , CURDATE()) as age',
            'jz_resume.gender',
            'jz_resume.college',
            'jz_resume.phonenum',
            'jz_task.title']
            )->from('jz_task_applicant')
             ->join('INNER JOIN', 'jz_resume',
				'jz_resume.user_id =jz_task_applicant.user_id')
             ->join('INNER JOIN', 'jz_task',
				'jz_task.id =jz_task_applicant.task_id')
             ->where(['jz_task.user_id' => $corpUserId]);

        return $query;
    }

    public function actionIndex()
    {
        $query = $this->findByCorpUserId(Yii::$app->user->id);
        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count]);
        $resumes = $query->offset($pagination->offset)
                         ->limit($pagination->limit)
                         ->all();

        $pages = new Pagination(['totalCount' => $query->count()]);
        return $this -> render('index', ['resumes' => $resumes, 'pagination' => $pagination]);
    }


}
