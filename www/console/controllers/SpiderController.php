<?php
/**
 */

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\console\Exception;
use common\models\Task;
use backend\models\TaskPool;

/**
 */

class SpiderController extends Controller
{
    /**
     * @var string controller default action ID.
     */

    public function actionImportInternalData()
    {
        $lastest = TaskPool::find()->orderBy(
            'id desc')->where(['origin'=>'internal'])->one();

        $max_id = $lastest?intval($lastest->origin_id):0;

        $tasks = Task::find()->where(['>', 'id', $max_id])
            ->andWhere(['origin'=>'internal'])
            ->all();

        $rows = [];
        foreach ($tasks as $task){
            $rows[] = $this->generateRow($task);
            if (count($rows)>200){
                $this->insertRows($rows);
                $rows = [];
            }
        }
        if (count($rows)>0){
            $this->insertRows($rows);
        }
        echo "Done with " . count($tasks) . ' tasks imported'. "\n";
    }

    public function generateRow($task)
    {
        $row = [];
        $row['company_name'] = $task->company?$task->company->name:'';
        $row['origin_id'] = $task->id;
        $row['origin'] = 'internal';
        $row['details'] = json_encode($task->toArray());
        $row['title'] = $task->title;
        $row['contact'] = $task->contact;
        $row['phonenum'] = $task->contact_phonenum;
        $row['release_date'] = $task->created_time;
        $row['to_date'] = $task->to_date;
        $row['city'] = $task->city?$task->city->name:"无";
        $row['status'] = TaskPool::STATUS_ZOMBIE;
        return $row;
    }

    public function insertRows($rows)
    {
        return Yii::$app->db->createCommand()->batchInsert(
            TaskPool::tableName(), 
            ['company_name', 'origin_id', 'origin', 'details', 
                'title', 'contact', 'phonenum', 'release_date', 'to_date',
                'city', 'status'],
            $rows
        )->execute();
    }
}

