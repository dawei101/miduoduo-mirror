<?php
namespace common\tasks;

use common\models\TaskQueue;


class TaskManager
{

    public function get($count=100)
    {
        $tasks = TaskQueue::find()
            ->where(['status'=>TaskQueue::STATUS_IN_QUEUE])
            ->andWhere(['<', 'start_time', time()])
            ->orderBy(['priority'=>SORT_DESC, 'id'=>SORT_DESC])
            ->limit($count)->all();
        return $tasks;
    }

    public function add(
        $task_name, $params, $start_time=time(), 
        $priority=TaskQueue::PRIORITY_MEDIUM, $retry_times = 3)
    {
        $task = new TaskQueue;
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
