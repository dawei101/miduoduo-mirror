<?php

namespace api\miduoduo\v1\models;

use Yii;

/**
 * This is the model class for table "{{%company}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $avatar
 * @property string $examined_time
 * @property integer $status
 * @property integer $examined_by
 * @property integer $user_id
 * @property string $contact_phone
 * @property string $contact_email
 * @property string $intro
 * @property string $contact_name
 * @property string $service
 * @property string $corp_type
 * @property string $corp_size
 * @property string $person_name
 * @property string $person_idcard
 * @property string $person_idcard_pic
 * @property string $corp_name
 * @property string $corp_idcard
 * @property string $corp_idcard_pic
 * @property integer $exam_result
 * @property integer $exam_status
 * @property string $exam_note
 * @property string $use_task_date
 * @property integer $use_task_num
 * @property string $created_time
 * @property integer $origin
 */
class Company extends \yii\db\ActiveRecord
{
    static $USE_TASK_LIMIT = [
        16 => 3,
        32 => 5,
        48 => 5,
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%company}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['examined_time', 'use_task_date', 'created_time'], 'safe'],
            [['status', 'examined_by', 'user_id', 'exam_result', 'exam_status', 'use_task_num', 'origin'], 'integer'],
            [['intro', 'exam_note'], 'string'],
            [['name'], 'string', 'max' => 500],
            [['avatar'], 'string', 'max' => 1000],
            [['contact_phone'], 'string', 'max' => 128],
            [['contact_email', 'contact_name', 'service', 'corp_type', 'corp_size', 'person_name', 'person_idcard', 'corp_name', 'corp_idcard'], 'string', 'max' => 256],
            [['person_idcard_pic', 'corp_idcard_pic'], 'string', 'max' => 512],
            ['user_id', 'unique', 'targetAttribute' => 'user_id',
                'message'=> '企业已经存在，请勿重新创建!'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'avatar' => 'Avatar',
            'examined_time' => 'Examined Time',
            'status' => 'Status',
            'examined_by' => 'Examined By',
            'user_id' => 'User ID',
            'contact_phone' => 'Contact Phone',
            'contact_email' => 'Contact Email',
            'intro' => 'Intro',
            'contact_name' => 'Contact Name',
            'service' => 'Service',
            'corp_type' => 'Corp Type',
            'corp_size' => 'Corp Size',
            'person_name' => 'Person Name',
            'person_idcard' => 'Person Idcard',
            'person_idcard_pic' => 'Person Idcard Pic',
            'corp_name' => 'Corp Name',
            'corp_idcard' => 'Corp Idcard',
            'corp_idcard_pic' => 'Corp Idcard Pic',
            'exam_result' => 'Exam Result',
            'exam_status' => 'Exam Status',
            'exam_note' => 'Exam Note',
            'use_task_date' => 'Use Task Date',
            'use_task_num' => 'Use Task Num',
            'created_time' => 'Created Time',
            'origin' => 'Origin',
        ];
    }

    public function getAllow_task_num(){
        if( isset(static::$USE_TASK_LIMIT[$this->exam_result]) ){
            return static::$USE_TASK_LIMIT[$this->exam_result];
        }else{
            return 1;
        }
    }

    public function fields()
    {
        return array_merge(parent::fields(), ['allow_task_num']);
    }
}
