<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%task_queue}}".
 *
 * @property integer $id
 * @property string $task_name
 * @property resource $params
 * @property integer $retry_times
 * @property string $start_time
 * @property integer $priority
 * @property integer $status
 */
class TaskQueue extends \common\BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%task_queue}}';
    }

    static $STATUSES = [
        0 => "队列中",
        1 => "执行中",
        2 => "执行完毕"
        10 => "执行失败",
    ];

    const STATUS_IN_QUEUE = 0;
    const STATUS_PROCESSING = 1;
    const STATUS_DONE = 2;
    const STATUS_FAILED = 10;

    const PRIORITY__HIGHEST = 4;
    const PRIORITY_HIGH = 3;
    const PRIORITY_MEDIUM = 2;
    const PRIORITY_LOW = 1;
    const PRIORITY_LOWEST = 0;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['task_name'], 'required'],
            [['params'], 'string'],
            [['retry_times', 'priority', 'status'], 'integer'],
            [['start_time'], 'safe'],
            [['task_name'], 'string', 'max' => 100],
            ['status', 'default', 'value'=>static::$STATUS_IN_QUEUE],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'task_name' => 'Task Name',
            'params' => 'Params',
            'retry_times' => 'Retry Times',
            'start_time' => 'Start Time',
            'priority' => 'Priority',
            'status' => 'Status',
        ];
    }

    /**
     * @inheritdoc
     * @return TaskQueueQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TaskQueueQuery(get_called_class());
    }

    public function setParams($params)
    {
        $this->params = serialize($params);
    }

    private $_params = false;

    public function getUnserializeParmas()
    {
        if (false===$this->_params){
            $this->_params = unserialize($this->params);
        }
        return $this->_params;
    }

    public function retryIfCan()
    {
        if ($this->retry_times>0){
            $this->retry_times -= 1;
            $this->status = $this::STATUS_IN_QUEUE;
            return true;
        }
        return false;
    }
}
