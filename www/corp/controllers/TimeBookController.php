<?php
namespace corp\controllers;

use Yii;
use corp\CBaseController;
use yii\web\HttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\Pagination;
use common\models\Task;
use common\models\TaskApplicant;


/**
 * Site controller
 */
class TimeBookController extends CBaseController
{

    public function actionIndex()
    {
        $query = Task::find()
            ->where(['user_id'=>Yii::$app->user->id])
            ->orderBy(['id'=> SORT_DESC]);

        $countQuery = clone $query;
        $pages =  new Pagination(['pageSize'=>Yii::$app->params['pageSize'],
            'totalCount' => $countQuery->count()]);

        $tasks = $query->offset($pages->offset)
            ->limit($pages->limit)->all();
        return $this->render('index', [
            'tasks' => $tasks,
            'pages' => $pages,
        ]);
    }

    public function actionWorkerSummary($gid)
    {
        $task = Task::find()
            ->where(['gid'=> $gid, 'user_id'=>Yii::$app->user->id])->one();
        if (!$task){
            throw new HttpException(404, '未知的任务');
        }

        $query = $task->getApplicants()->with('resume')->with('address');

        $countQuery = clone $query;
        $pages =  new Pagination(['pageSize'=>Yii::$app->params['pageSize'],
            'totalCount' => $countQuery->count()]);

        $applicants = $query->offset($pages->offset)
            ->limit($pages->limit)->all();

        return $this->render('summary', [
            'task' => $task,
            'subject' => 'worker',
            'models' => $applicants,
            'pages' => $pages,
        ]);
    }


    public function actionAddressSummary($gid)
    {
        $task = Task::find()->with('resumes')
            ->where(['gid'=> $gid, 'user_id'=>Yii::$app->user->id])->one();
        if (!$task){
            throw new HttpException(404, '未知的任务');
        }
        return $this->render('summary', [
            'task' => $task,
            'subject' => 'address',
        ]);
    }

    public function actionDateSummary($gid)
    {
        $task = Task::find()->with('resumes')
            ->where(['gid'=> $gid, 'user_id'=>Yii::$app->user->id])->one();
        if (!$task){
            throw new HttpException(404, '未知的任务');
        }
        return $this->render('summary', [
            'task' => $task,
            'subject' => 'date',
        ]);
    }

    public function actionSettings($user_id, $task_id)
    {
        $applicant = TaskApplicant::find()
            ->where(['user_id'=>$user_id, 'task_id'=> $task_id])->one();
        if (!$applicant){
            throw new HttpException(404, '未知的请求');
        }
        return $this->render('settings',
            ['applicant'=>$applicant]
        );
    }

    public function actionDetail($task_id, $user_id=null, $date=null, $address_id=null)
    {
        return $this->render('detail', [
        ]);
    }
}
