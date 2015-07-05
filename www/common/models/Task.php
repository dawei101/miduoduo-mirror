<?php

namespace common\models;

use Yii;
use common\models\TaskAddress;
use common\models\Company;
use common\models\District;
use common\models\ServiceType;

/**
 * This is the model class for table "{{%task}}".
 *
 * @property integer $id
 * @property string $gid
 * @property string $title
 * @property integer $clearance_period
 * @property string $salary
 * @property integer $salary_unit
 * @property string $salary_note
 * @property string $from_date
 * @property int $company_id
 * @property string $contact;
 * @property string $contact_phonenum;
 * @property string $to_date
 * @property string $from_time
 * @property string $to_time
 * @property integer $need_quantity
 * @property integer $got_quantity
 * @property string $created_time
 * @property string $updated_time
 * @property string $detail
 * @property string $requirement
 * @property string $address
 * @property integer $user_id
 * @property integer $service_type_id
 * @property integer $gender_requirement
 * @property integer $degree_requirement
 * @property integer $age_requirement
 * @property integer $height_requirement
 * @property integer $status
 * @property integer $city_id
 * @property integer $district_id
 * @property string $labels_str
 */
class Task extends \common\BaseActiveRecord
{

    public static $CLEARANCE_PERIODS = [
        0=>'月结',
        1=>'周结',
        2=>'日结',
    ];

    public static $SALARY_UNITS = [
        0=>'小时',
        1=>'天',
        2=>'周',
        3=>'月',
    ];

    public static $STATUSES = [
        0=>'正常',
        10=>'下线',
    ];

    public function getStatus_label()
    {
        return static::$STATUSES[$this->status];
    }


    public function getClearance_period_label()
    {
        return static::$CLEARANCE_PERIODS[$this->clearance_period];
    }

    public function getSalary_unit_label()
    {
        return static::$SALARY_UNITS[$this->salary_unit];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%task}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['salary', 'salary_unit', 'from_date', 'to_date',
                'need_quantity', 'detail',
                'service_type_id', 'title'], 'required'],
            ['company_id', 'required', 'message'=>'请选择一个已存在的公司'],
            [['id', 'clearance_period', 'salary_unit', 'need_quantity',
                'got_quantity', 'user_id', 'service_type_id',
                'gender_requirement', 'degree_requirement', 'age_requirement',
                'height_requirement', 'status', 'city_id', 'district_id',
                'company_id'], 'integer'],
            [['salary'], 'number'],
            [['salary_note', 'detail', 'requirement'], 'string'],
            [['from_date', 'to_date', 'from_time', 'to_time',
                'created_time', 'updated_time'], 'safe'],
            [['gid'], 'string', 'max' => 1000],
            [['title', 'address'], 'string', 'max' => 500],
            ['created_time', 'default', 'value'=>time(), 'on'=>'insert'],
            ['updated_time', 'default', 'value'=>time(), 'on'=>'update'],
            [['from_date', 'to_date'], 'date', 'format' => 'yyyy-M-d'],
            [['from_time', 'to_time'], 'date', 'format' => 'H:i'],
            ['got_quantity', 'default', 'value'=>0],
            ['company_id', 'default', 'value'=>0],
            ['status', 'default', 'value'=>0],
            [['contact', 'contact_phonenum'], 'required'],
            ['contact_phonenum', 'match', 'pattern'=>'/^(1[345789]\d{9})|(\d{3,4}\-?\d{7,8})$/',
                'message'=>'请输入正确的电话'],
            ['clearance_period', 'default', 'value'=>0],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'gid' => '订单号',
            'title' => '标题',
            'clearance_period' => '结算方式',
            'clearance_period_label' => '结算方式',

            'salary' => '薪资',
            'salary_unit' => '薪资单位',
            'salary_unit_label' => '薪资单位',

            'salary_note' => '薪资说明',
            'from_date' => '开始日期',
            'to_date' => '结束日期',
            'from_time' => '上班时间',
            'to_time' => '下班时间',
            'need_quantity' => '需要数量',
            'got_quantity' => '报名数量',
            'created_time' => '创建时间',
            'updated_time' => '修改时间',
            'detail' => '工作内容',
            'requirement' => '其他要求',
            'address' => '地址',
            'user_id' => '发布人',
            'company_id' => '公司',
            'service_type_id' => '服务类型',
            'gender_requirement' => '性别',
            'degree_requirement' => '学历',
            'age_requirement' => '年龄',
            'height_requirement' => '身高',
            'status' => '状态',
            'status_label' => '状态',
            'city_id' => '城市',
            'district_id' => '区域',

            'contact'=>'联系人',
            'contact_phonenum'=>'联系手机',
            'labels_str'=>'标签',

        ];
    }

    public function beforeValidate()
    {
        return parent::beforeValidate();
    }

    public function beforeSave($insert) 
    {
        if ($this->isNewRecord){ 
            $user_id = Yii::$app->user->id; 
            $this->user_id = $user_id; 
            $this->gid = time() . mt_rand(100, 999) . $user_id; 
        }
        return parent::beforeSave($insert); 
    }

    public function tidyTitle()
    {
        return preg_replace('/【.*?】/', '', $this->title);
    }

    /**
     * @inheritdoc
     * @return TaskQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TaskQuery(get_called_class());
    }

    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }

    public function getCity()
    {
        return $this->hasOne(District::className(), ['id' => 'city_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getAddresses()
    {
        return $this->hasMany(TaskAddress::className(), ['task_id' => 'id']);
    }


    public function getDistrict()
    {
        return $this->hasOne(District::className(), ['id' => 'district_id']);
    }

    public function getService_type()
    {
        return $this->hasOne(ServiceType::className(), ['id' => 'service_type_id']);
    }

    public function getLabels()
    {
        return explode(',', $this->labels_str);
    }

    public function setLabels($labels)
    {
        $this->labels_str = implode(',', $labels);
    }

    public function extraFields()
    {
        return ['city', 'district', 'user', 'service_type', 'company', 'addresses'];
    }

    public function getLabel_options()
    {
        return [];
    }

    /*
     *  TODO 临时方法，为了迁移company数据到独立表
     */
    public function getCompany_name()
    {
        if ($this->company_id){
            return $this->company->name;
        }
    }

    public function getCompany_introduction()
    {
        if ($this->company_id){
            return $this->company->introduction;
        }
    }

    public function fields()
    {
        return [
            'id', 'gid', 'title', 'clearance_period', 'salary', 'salary_unit',
            'salary_note', 'from_date', 
            'contact', 'contact_phonenum',
            'to_date', 'from_time', 'to_time', 'need_quantity',
            'got_quantity', 'created_time', 'updated_time', 'detail',
            'requirement', 'address',
            'age_requirement', 'height_requirement', 'status',
            'user_id', 'service_type_id',
            'city_id', 'district_id', 'company_id',
            'gender_requirement', 'degree_requirement',
            'clearance_period_label', 'salary_unit_label',
            'labels', 'label_options', 'status_label',
        ];
    }
}
