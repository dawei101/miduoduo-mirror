<?php
namespace common\tasks;

use common\models\JobQueue;


class JobQueueManager
{
    public $batch_size = 100;

    public function get($count=null)
    {
        $count = $count?$count:$this->batch_size;

        $tasks = JobQueue::find()
            ->where(['status'=>JobQueue::STATUS_IN_QUEUE])
            ->andWhere(['<', 'start_time', time()])
            ->orderBy(['priority'=>SORT_DESC, 'id'=>SORT_DESC])
            ->limit($count)->all();
        return $tasks;
    }

    public function add(
        $task_name, $params, $start_time=time(), 
        $priority=JobQueue::PRIORITY_MEDIUM, $retry_times = 3)
    {
        $task = new JobQueue;
        $task->task_name = $task_name;
        $task->setParams($params);
        $task->start_time = $start_time;
        $task->priority = $priority;
        $task->retry_times = $retry_times;
        $task->save();
    }

    public function retry($task)
    {
        return $task->retryIfCan();
    }

}
