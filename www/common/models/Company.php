<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%company}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $examined_time
 * @property integer $status
 * @property integer $examined_by
 * @property integer $user_id
 */
class Company extends \common\BaseActiveRecord
{

    static $STATUSES = [
        0 => '正常',
        5 => '已冻结',
        10 => '已删除',
        20 => '黑名单',
    ];

    const STATUS_OK = 0;
    const STATUS_FREEZED = 5;
    const STATUS_DELETED = 10;
    const STATUS_BLACKLISTED =20;

    static $EXAM_STATUSES = [
        0 => '未验证',
        1 => '等待审核',
        2 => '审核完成',
        10 => '审核未通过',
    ];

    const EXAM_TODO = 0;
    const EXAM_PROCESSING  = 1;
    const EXAM_DONE = 2;
    const EXAM_NOT_PASSED = 10;

    static $EXAM_RESULTS = [
        16 => '身份证验证通过',
        32 => '营业执照验证通过',
    ];

    const EXAM_GOVID_PASSED = 16;
    const EXAM_LICENSE_PASSED = 32;

    public function getExam_status_label()
    {
        return static::$EXAM_STATUSES[$this->exam_status];
    }

    public function getExam_result_label()
    {
        $s = '';
        if (static::EXAM_GOVID_PASSED & $this->exam_result){
            $s .= ' ' . static::$EXAM_RESULTS[static::EXAM_GOVID_PASSED];
        }
        if ($this->exam_result & static::EXAM_LICENSE_PASSED){
            $s .= ' ' . static::$EXAM_RESULTS[static::EXAM_LICENSE_PASSED];
        }
        return $s;
    }

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
            [['name'], 'required'],
            [['id', 'status', 'examined_by', 'user_id', 'exam_result'], 'integer'],
            [['examined_time'], 'safe'],
            [['name', ], 'string', 'max' => 500],
            [['name', 'contact_phone', 'contact_email', 'contact_name'], 'string', 'max' => 500],
            [['intro'], 'string'],
            ['contact_email', 'email'],
            ['status', 'default', 'value'=>0],
            ['contact_phone', 'match', 'pattern'=>'/^(1[345789]\d{9})|(0\d{2,3}\-?\d{7,8})$/',
                'message'=>'电话号码格式不正确.'],
            [['name', 'contact_name', 'contact_phone', 'contact_email'], 'required'],
            [['exam_status', 'exam_result'], 'integer'],
            ['exam_note', 'string'],
            [['person_idcard_pic', 'corp_idcard_pic'], 'string'],
            [['person_idcard'], 'pattern', '/^\d{15-18}[xX]?$/'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '企业名',
            'intro'=>'公司介绍',
            'examined_time' => '审核日期',
            'examined_by' => '审核人',
            'user_id' => '用户',
            'contact_phone' => '联系电话',
            'contact_name' => '联系人',
            'contact_email' => '招聘邮箱',
            'person_idcard_pic' => '身份证照片',
            'corp_idcard_pic' => '营业执照照片',
            'exam_status' => '审核状态',
            'exam_status_label' => '审核状态',
            'exam_result' => '审核结果 ',
            'exam_result_label' => '审核结果 ',
            'status' => '状态',
            'status_label' => '状态',
            'person_idcard' => '身份证号',
            'corp_idcard' => '营业执照号',
        ];
    }

    /**
     * @inheritdoc
     * @return CompanyQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CompanyQuery(get_called_class());
    }

    public function getStatus_label()
    {
        return static::$STATUSES[$this->status];
    }

    /**
     * @inheritdoc
     */
    public static function findByCurrentUser()
    {
        return static::findOne(['user_id' => Yii::$app->user->id]);
    }

    public function beforeSave($insert)
    {
        if ($this->isNewRecord){
            $user_id = Yii::$app->user->id;
            $this->user_id = $user_id;
        }
        return parent::beforeSave($insert);
    }

    public static function createCompanyWithCurrentUser(){
        $company = new Company;
        $company->user_id = Yii::$app->user->id;
        if ($company->save()){
            return $company;
        }
        return false;
    }

    public static function updateContactInfo($name, $phone, $email, $contact)
    {
        $company = static::findByCurrentUser();
        if (!$company) {
            //we build a company for first visit
            $company = static::createCompanyWithCurrentUser();
        }
        if (!$company) {
            return false;
        }
        $company->name = $name;
        $company->contact_phone = $phone;
        $company->contact_email = $email;
        $company->contact_name = $contact;
        return $company->save();
    }

    public function fields()
    {
        return array_merge(parent::fields, ['status_label', 'exam_status_label', 'exam_result_label']);
    }
}
