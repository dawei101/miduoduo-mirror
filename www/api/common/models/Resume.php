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
            [['gender', 'height', 'is_student', 'grade', 'status', 'user_id', 'home', 'workplace'], 'integer'],
            [['birthdate', 'created_time', 'updated_time'], 'safe'],
            [['birthdate'], 'date', 'format' => 'yyyy-M-d'],
            [['name', 'degree', 'college'], 'string', 'max' => 500],
            [['nation'], 'string', 'max' => 255],
            [['avatar'], 'string', 'max' => 2048],
            [['gov_id'], 'string', 'max' => 50],
            [['phonenum'], 'string', 'max' => 45],
            ['gender', 'in', 'range'=>array_keys(static::$GENDERS)],
            [['gov_id'], 'match', 'pattern' => '/^\d{15,18}[Xx]?$/'],
            [['home', 'workplace'], 'default', 'value'=>0],
            ['phonenum', 'checkPhonenum'],
            ['status', 'default', 'value'=>0],
            ['origin', 'default', 'value'=>'self'],
            ['job_wishes', 'string', 'max'=>500],
            ['major', 'string', 'max'=>200],
            ['gender', 'default', 'value'=>0],
        ];
    }

    public function checkPhonenum($attr, $params)
    {
        if (!Yii::$app->user->isGuest && empty($phonenum)){
            $this->phonenum = Yii::$app->user->identity->username;
        }
        if (!Utils::isPhonenum($this->phonenum)){
            $this->addError($attr, "手机号不正确，目前仅支持中国大陆手机号.");
        }
    }

}
