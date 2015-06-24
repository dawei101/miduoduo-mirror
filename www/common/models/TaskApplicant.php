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
            [['user_id', 'task_id'], 'integer'],
            ['created_time', 'default', 'value'=>time(), 'on'=>'insert'],
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
}
