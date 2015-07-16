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
                        'actions' => ['index', 'read', 'pass', 'reject'],
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

    public function findByCorpUserId($corpUserId, $status=false)
    {
        $query = new Query;
        $condition = ['jz_task.user_id' => $corpUserId];
        if ($status !== false) {
            $condition['jz_task_applicant.status'] = $status;
        }
        $query ->select([
            'jz_task_applicant.id',
            'jz_task_applicant.created_time',
            'jz_task_applicant.status',
            'jz_resume.name',
            'TIMESTAMPDIFF(YEAR, jz_resume.birthdate , CURDATE()) as age',
            'jz_resume.gender',
            'jz_resume.college',
            'jz_resume.phonenum',
            'jz_task.title',
            'jz_task.gid',
            ]
            )->from('jz_task_applicant')
             ->join('LEFT OUTER JOIN', 'jz_resume',
				'jz_resume.user_id = jz_task_applicant.user_id')
             ->join('LEFT OUTER JOIN', 'jz_task',
				'jz_task.id = jz_task_applicant.task_id')
             ->where($condition);

        return $query;
    }

    public function actionIndex($status=false)
    {
        $query = $this->findByCorpUserId(Yii::$app->user->id, $status);
        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count]);
        $resumes = $query->offset($pagination->offset)
                         ->limit($pagination->limit)
                         ->all();

        return $this -> render('index', ['resumes' => $resumes, 'pagination' => $pagination]);
    }

    public function actionRead($aid)
    {
        $resume = TaskApplicant::findOne(['id' => $aid]);
        $resume->have_read = 1;
        if ($resume->save()) {
            return $this->renderJson(['result' => true]);
        }
        return $this->renderJson(['result' => false, 'error' => $resume->errors]);
    }

    public function actionPass($aid)
    {
        $resume = TaskApplicant::findOne(['id' => $aid]);
        $resume->status = 10;
        if ($resume->save()) {
            return $this->renderJson(['result' => true]);
        }
        return $this->renderJson(['result' => false, 'error' => $resume->errors]);
    }

    public function actionReject($aid)
    {
        $resume = TaskApplicant::findOne(['id' => $aid]);
        $resume->status = 20;
        if ($resume->save()) {
            return $this->renderJson(['result' => true]);
        }
        return $this->renderJson(['result' => false, 'error' => $resume->errors]);
    }
}
