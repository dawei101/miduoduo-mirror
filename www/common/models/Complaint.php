<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%complaint}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property integer $task_id
 * @property integer $user_id
 * @property string $created_time
 * @property String $phonenum
 * @property integer $status
 */
class Complaint extends \common\BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%complaint}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content', 'task_id', 'phonenum'], 'required'],
            [['content', 'title'], 'string'],
            [['task_id', 'user_id', 'status'], 'integer'],
            [['created_time'], 'safe'],
            ['phonenum', 'match', 'pattern'=>'/^1[345789]\d{9}$/',
                'message'=>'手机号不正确，目前仅支持中国大陆手机号.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '标题',
            'content' => '内容',
            'task_id' => '任务',
            'user_id' => '用户',
            'phonenum' => '手机号',
            'created_time' => '创建时间',
            'status' => '状态',
        ];
    }

    /**
     * @inheritdoc
     * @return ComplaintQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ComplaintQuery(get_called_class());
    }
}
