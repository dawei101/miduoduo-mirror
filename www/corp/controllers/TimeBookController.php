<?php
namespace corp\controllers;

use Yii;
use yii\web\HttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\Pagination;
use corp\CBaseController;

use common\Utils;
use common\models\Task;
use common\models\TaskApplicant;
use corp\models\time_book\Record;
use corp\models\time_book\Schedule;


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

    public function openTimeBook($task)
    {
        if (!$task->time_book_opened){
            $task->time_book_opened = true;
            $task->save();
        }
    }

    public function actionWorkerSummary($gid)
    {
        $task = Task::find()
            ->where(['gid'=> $gid, 'user_id'=>Yii::$app->user->id])->one();
        if (!$task){
            throw new HttpException(404, '未知的任务');
        }
        $this->openTimeBook($task);

        $query = $task->getApplicants()->with('resume')->with('address');

        $countQuery = clone $query;
        $pages =  new Pagination(['pageSize'=>Yii::$app->params['pageSize'],
            'totalCount' => $countQuery->count()]);

        $applicants = $query->offset($pages->offset)
            ->limit($pages->limit)->all();

        $user_ids = [];

        foreach ($applicants as $a){
            $user_ids[] = $a->user_id;
        }

        $ss = Schedule::find()
            ->select("
                count(1) as count,
                sum('on_late') as on_late_count,
                sum('off_early') as off_late_count,
                sum('out_work') as out_work_count,
                sum(CASE WHEN note is null OR note = '' THEN 0 ELSE 1 END) as noted_count
            ")
            ->groupBy('user_id')
            ->where(['task_id'=>$task->id, 'user_id'=>$user_ids])->all();
        $summaries = [];
        foreach ($ss as $s){
            $summaries[$s->user_id] = $s;
        }

        return $this->render('summary', [
            'task' => $task,
            'subject' => 'worker',
            'models' => $applicants,
            'summaries' => $summaries,
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

    public function actionAdd($gid)
    {

        $task = Task::find()->with('resumes')->with('addresses')
            ->where(['gid'=> $gid, 'user_id'=>Yii::$app->user->id])->one();
        if (!$task){
            throw new HttpException(404, '未知的任务');
        }
        return $this->render('add', [
            'task' => $task,
        ]);
    }
}
