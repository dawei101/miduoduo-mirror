<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%task_applicant}}".
 *
 * @property integer $id
 * @property string $created_time
 * @property integer $user_id
 * @property integer $task_id
 *
 * @property User $user
 * @property Task $task
 */
class TaskApplicant extends \common\BaseActiveRecord
{

    public static $STATUSES = [
        0 => '等待企业确认',
        10 => '报名成功',
    ];

    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%task_applicant}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_time'], 'safe'],
            [['user_id', 'task_id'], 'required'],
            [['user_id', 'task_id', 'status'], 'integer'],
            ['created_time', 'default', 'value'=>time(), 'on'=>'insert'],
            ['task_id', 'unique', 'targetAttribute' => ['task_id', 'user_id'], 'message'=>'已报名过'],
            [['company_alerted', 'applicant_alerted'], 'default', 'value'=>'false'],
            ['status', 'default', 'value'=>0],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_time' => '申请时间',
            'user_id' => '用户',
            'task_id' => '任务',
            'status' => '状态',
            'status_label' => '状态',
            'company_alerted' => '已通知企业?',
            'applicant_alerted' => '已通知用户?',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Task::className(), ['id' => 'task_id']);
    }

    public function getResume(){
        
        return $this->hasOne(Resume::className(), ['user_id' => 'user_id']);
    }

    /**
     * @inheritdoc
     * @return TaskApplicantQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TaskApplicantQuery(get_called_class());
    }

    public static function isApplied($user_id, $task_id)
    {
        return static::find()->where([
            'user_id' => $user_id,
            'task_id' => $task_id
        ])->exists();
    }

    public function getStatus_label()
    {
        return $this::$STATUSES[$this->status];
    }

    public function getStatus_options()
    {
        return $this::$STATUSES;
    }

    public function fields()
    {
        return array_merge(parent::fields(), ['status_label', 'status_options']);
    }

    public function extraFields()
    {
        return ['task', 'user'];
    }
}
