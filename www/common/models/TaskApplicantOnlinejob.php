<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%task_applicant_onlinejob}}".
 *
 * @property integer $id
 * @property integer $status
 * @property integer $app_id
 * @property integer $user_id
 * @property integer $task_id
 * @property string $needinfo
 * @property integer $has_sync_wechat_pic
 */
class TaskApplicantOnlinejob extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%task_applicant_onlinejob}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'app_id', 'user_id', 'task_id', 'has_sync_wechat_pic'], 'integer'],
            [['needinfo'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '在线任务提交id',
            'status' => '状态',
            'app_id' => '任务报名id',
            'user_id' => '用户id',
            'task_id' => '任务id',
            'needinfo' => '序列化的任务提交信息',
            'has_sync_wechat_pic' => '是否已经同步微信上传图片',
        ];
    }
}
