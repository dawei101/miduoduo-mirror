<?php

namespace common\models;

use Yii;
use common\models\Address;
use common\models\Company;

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
 * @property string $to_date
 * @property string $from_time
 * @property string $to_time
 * @property integer $need_quantity
 * @property integer $got_quantity
 * @property string $created_time
 * @property string $updated_time
 * @property string $detail
 * @property string $requirement
 * @property integer $address_id
 * @property integer $user_id
 * @property integer $service_type_id
 * @property integer $gender_requirement
 * @property integer $degree_requirement
 * @property integer $age_requirement
 * @property integer $height_requirement
 * @property integer $status
 * @property integer $city_id
 * @property integer $district_id
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
            [['id', 'salary', 'salary_unit', 'from_date', 'to_date',
                'need_quantity', 'detail', 'address_id', 'user_id',
                'service_type_id', 'city_id'], 'required'],
            [['id', 'clearance_period', 'salary_unit', 'need_quantity',
                'got_quantity', 'address_id', 'user_id', 'service_type_id',
                'gender_requirement', 'degree_requirement', 'age_requirement',
                'height_requirement', 'status', 'city_id', 'district_id',
                'company_id'], 'integer'],
            [['salary'], 'number'],
            [['salary_note', 'detail', 'requirement'], 'string'],
            [['from_date', 'to_date', 'from_time', 'to_time',
                'created_time', 'updated_time'], 'safe'],
            [['gid'], 'string', 'max' => 1000],
            [['title'], 'string', 'max' => 500],
            ['created_time', 'default', 'value'=>time(), 'on'=>'insert'],
            ['updated_time', 'default', 'value'=>time(), 'on'=>'update'],
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
            'salary' => '薪资',
            'salary_unit' => '薪资单位',
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
            'address_id' => '地址',
            'user_id' => '发布人',
            'company_id' => '公司',
            'service_type_id' => '服务类型',
            'gender_requirement' => '性别',
            'degree_requirement' => '学历',
            'age_requirement' => '年龄',
            'height_requirement' => '身高',
            'status' => '状态',
            'city_id' => '城市',
            'district_id' => '区域',
        ];
    }

   public function beforeSave($insert) 
   { 
       if ($this->isNewRecord){ 
           $user_id = Yii::$app->user->id; 
           $this->created_by = $user_id; 
           $this->gid = time() . mt_rand(100, 999) . $user_id; 
       } 
       return parent::beforeSave($insert); 
   }

    /**
     * @inheritdoc
     * @return TaskQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TaskQuery(get_called_class());
    }

    public function getAddress()
    {
        return $this->hasOne(Address::className(), ['id' => 'address_id']);
    }

    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }
}
