<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%sys_message}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $read_flag
 * @property string $message
 * @property string $title
 * @property string $created_time
 * @property integer $has_sent
 */
class SysMessage extends \common\BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sys_message}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'message', 'title'], 'required'],
            [['user_id', 'read_flag', 'has_sent'], 'integer'],
            [['message'], 'string'],
            [['created_time'], 'safe'],
            [['title'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'read_flag' => 'Read Flag',
            'message' => 'Message',
            'title' => 'Title',
            'created_time' => '创建时间',
            'has_sent' => '已发送',
        ];
    }

    /**
     * @inheritdoc
     * @return SysMessageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SysMessageQuery(get_called_class());
    }
}
