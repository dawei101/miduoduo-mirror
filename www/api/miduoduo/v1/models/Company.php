<?php

namespace api\miduoduo\v1\models;

use Yii;
use common\Utils;


class Company extends \common\models\Company
{
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['id', 'status', 'examined_by', 'user_id', 'exam_result'], 'integer'],
            ['user_id', 'unique', 'targetAttribute' => 'user_id',
                'message'=> '企业经存在，请勿重新创建!'],
            [['examined_time','use_task_date','use_task_num','person_name','corp_idcard'], 'safe'],
            [['name', ], 'string', 'max' => 500],
            [['name', 'contact_phone', 'contact_email', 'contact_name'], 'string', 'max' => 500],
            [['intro'], 'string'],
            ['contact_email', 'email'],
            ['status', 'default', 'value'=>0],
            ['contact_phone', 'match', 'pattern'=>'/^(1[345789]\d{9})|(0\d{2,3}\-?\d{7,8})$/',
                'message'=>'电话号码格式不正确.'],
            [['name', 'contact_name', 'contact_phone'], 'required'],
            [['exam_status', 'exam_result'], 'integer'],
            ['exam_note', 'string'],
            [['person_idcard_pic', 'corp_idcard_pic'], 'string'],
            ['person_idcard', 'match', 'pattern'=>'/^\d{15,18}[xX]?$/', 'message'=> '身份证号有误'],
        ];
    }
}
