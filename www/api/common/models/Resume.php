<?php

namespace api\common\models;

use Yii;
use common\Utils;

class Resume extends \common\models\Resume
{
    public function rules()
    {
        return [
            [['name'], 'required'],
            ['user_id', 'unique', 'targetAttribute' => 'user_id',
                'message'=> '简历已经存在，请勿重新创建!'],
            [['gender', 'is_student', 'grade', 'degree',
                'status', 'user_id', 'home', 'workplace', ], 'integer'],
            [['birthdate', 'created_time', 'updated_time'], 'safe'],
            [['weight', 'height'], 'safe'],
            [['birthdate'], 'date', 'format' => 'yyyy-M-d'],
            [['name', 'college'], 'string', 'max' => 500],
            [['nation'], 'string', 'max' => 255],
            [['avatar'], 'string', 'max' => 2048],
            [['gov_id'], 'string', 'max' => 50],
            [['phonenum'], 'string', 'max' => 45],
            ['gender', 'in', 'range'=>array_keys(static::$GENDERS)],
            [['gov_id'], 'match', 'pattern' => '/^\d{15,18}[Xx]?$/'],
            [['home', 'workplace'], 'default', 'value'=>0],
            ['status', 'default', 'value'=>0],
            ['origin', 'default', 'value'=>'self'],
            ['job_wishes', 'string', 'max'=>500],
            ['major', 'string', 'max'=>200],
            ['gender', 'default', 'value'=>0],
            [['intro'], 'string', 'max'=>5000],
        ];
    }
}
