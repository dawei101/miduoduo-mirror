<?php

namespace common\models;

use Yii;
use common\models\User;
use common\models\Address;
use common\models\TaskApplicant;

/**
 * This is the model class for table "{{%resume}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $phonenum
 * @property integer $gender
 * @property string $birthdate
 * @property int $degree
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
 * @property text intro;
 */
class Resume extends \common\BaseActiveRecord
{

    public static $STATUSES = [
        0 => '正常',
        10 => '已删除',
    ];

    const STATUS_OK = 0;
    const STATUS_DELETED = 10;

    public static function tableName()
    {
        return '{{%resume}}';
    }

    public static $GENDERS = [0=>'男', 1=>'女'];
    public static $GRADES= [0=>'无', 1=>'一年级', 2=>'二年级',
        3=>'三年级', 4=>'四年级', 5=>'五年级'];
    public static $STUDENTS=[0=>'否', 1=>'是'];

    public static $DEGREES = [
        1 => '初中',
        2 => '高中/中专',
        3 => '大专',
        4 => '本科',
        5 => '研究生',
        6 => '博士生',
    ];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'phonenum'], 'required'],
            [['gender', 'height', 'is_student', 'grade', 'degree',
                'has_emdical_cert', 'status',
                'user_id', 'home', 'workplace'], 'integer'],
            [['birthdate', 'created_time', 'updated_time'], 'safe'],
            [['birthdate'], 'date', 'format' => 'yyyy-M-d'],
            [['name', 'college'], 'string', 'max' => 500],
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
            ['grade', 'default', 'value'=>0],
            [['intro'], 'string', 'max'=>5000],
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
            'weight' => '体重',
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
            'intro' => '自我介绍',
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
        if (!$this->phonenum){
            $this->phonenum = Yii::$app->user->identity->username;
        }
        return parent::beforeSave($insert);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getService_types()
    {
        return $this->hasMany(ServiceType::className(), ['id' => 'service_type_id'])
            ->viaTable(UserHasServiceType::tableName(), ['user_id' => 'user_id']);
    }

    public function getFreetimes()
    {
        return $this->hasMany(Freetime::className(), ['user_id' => 'user_id']);
    }

    public function getHome_address()
    {
        return $this->hasOne(Address::className(), ['id' => 'home']);
    }

    public function getWorkplace_address()
    {
        return $this->hasOne(Address::className(), ['id' => 'workplace']);
    }

    public function getApplicantDone(){
        return $this->hasMany(TaskApplicant::className(),['user_id' => 'user_id'])
            ->where(['status'=>10])
            ->orderBy(['id'=>SORT_DESC])
            ->limit(20)
            ->with('task');
    }

    public function getGender_label()
    {
        return static::$GENDERS[$this->gender];
    }

    public function getGrade_label()
    {
        return static::$GRADES[$this->grade];
    }

    public function getDegree_label()
    {
        if ($this->degree){
            return static::$DEGREES[$this->degree];
        }
        return '未知';
    }

    public function getDegree_options()
    {
        return static::$DEGREES;
    }

    public function getStatus_label()
    {
        return static::$STATUSES[$this->status];
    }

    public function getAge()
    {
        if ($this->birthdate){
            return intval(date('Y', time())) - intval(explode(',', strval($this->birthdate))[0]);
        }
        return 0;
    }

    public function getCommon_url()
    {
        return Yii::$app->params['baseurl.frontend'] . '/resume-' . $this->user_id . '-' . $this->name;
    }

    public function fields()
    {
        return array_merge(parent::fields(), ['gender_label', 'age', 'degree_label', 'degree_options']);
    }

    public function extraFields()
    {
        return ['user', 'home_address', 'workplace_address', 'service_types', 'freetimes'];
    }

}
