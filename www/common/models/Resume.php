<?php

namespace common\models;

use Yii;
use common\models\User;
use common\models\Address;

/**
 * This is the model class for table "{{%resume}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $phonenum
 * @property integer $gender
 * @property string $birthdate
 * @property string $degree
 * @property string $nation
 * @property integer $height
 * @property integer $is_student
 * @property string $college
 * @property string $avatar
 * @property string $gov_id
 * @property integer $grade
 * @property string $created_time
 * @property string $updated_time
 * @property integer $status
 * @property integer $user_id
 * @property integer $home
 * @property integer $workplace
 * @property varchar(200) $origin
 * @property varchar(200) $major
 * @property varchar(1000) job_willes
 */
class Resume extends \common\BaseActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%resume}}';
    }

    public static $GENDERS = [0=>'男', 1=>'女'];
    public static $GRADES= [0=>'无', 1=>'一年级', 2=>'二年级',
        3=>'三年级', 4=>'四年级', 5=>'五年级'];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'phonenum'], 'required'],
            [['gender', 'height', 'is_student', 'grade', 'status', 'user_id', 'home', 'workplace'], 'integer'],
            [['birthdate', 'created_time', 'updated_time'], 'safe'],
            [['birthdate'], 'date', 'format' => 'yyyy-M-d'],
            [['name', 'degree', 'college'], 'string', 'max' => 500],
            [['nation'], 'string', 'max' => 255],
            [['avatar'], 'string', 'max' => 2048],
            [['gov_id'], 'string', 'max' => 50],
            [['phonenum'], 'string', 'max' => 45],
            ['phonenum', 'match', 'pattern'=>'/^1[345789]\d{9}$/',
                'message'=>'手机号不正确，目前仅支持中国大陆手机号.'],
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
        if (!$this->user_id && $this->phonenum && User::findByUsername($this->phonenum)){
            $this->addError($attr, "该手机号已被注册过");
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '姓名',
            'phonenum' => '手机号',
            'gender' => '性别',
            'birthdate' => '生日',
            'degree' => '学历',
            'nation' => '民族',
            'height' => '身高(cm)',
            'is_student' => '是学生',
            'college' => '学校',
            'major' => '专业',
            'avatar' => '头像',
            'gov_id' => '身份证号',
            'grade' => '年级',
            'created_time' => '创建日期',
            'updated_time' => '修改日期',
            'status' => '状态',
            'user_id' => '用户',
            'home' => '住址',
            'workplace' => '工作地址',
            'job_wishes' => '工作意愿',
        ];
    }

    /**
     * @inheritdoc
     * @return ResumeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ResumeQuery(get_called_class());
    }

    public function beforeSave($insert)
    {
        if (!$this->user_id){
            $user = User::createUserWithPhonenum($this->phonenum);
            $this->user_id = $user->id;
        }
        return parent::beforeSave($insert);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getHome_address()
    {
        return $this->hasOne(Address::className(), ['id' => 'home']);
    }

    public function getWorkplace_address()
    {
        return $this->hasOne(Address::className(), ['id' => 'workplace']);
    }

    public function extraFields()
    {
        return ['user', 'home_address', 'workplace_address'];
    }

}
