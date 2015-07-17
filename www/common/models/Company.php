<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%company}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $license_id
 * @property string $license_img
 * @property string $examined_time
 * @property integer $status
 * @property integer $examined_by
 * @property integer $user_id
 */
class Company extends \common\BaseActiveRecord
{

    static $STATUSES = [
        0 => '正常',
        1 => '未验证',
        2 => '验证中',
        4 => '验证失败',
        5 => '已冻结',
        10 => '已删除',
        20 => '黑名单',
    ];

    const STATUS_OK = 0;
    const STATUS_WAIT_EXAMINE = 1;
    const STATUS_EXAMINEING = 2;
    const STATUS_EXAMINE_FAILED = 4;
    const STATUS_FREEZED = 5;
    const STATUS_DELETED = 10;
    const STATUS_BLACKLISTED =20;

    static $EXAMINE_VALUES = [
        1 => '身份证验证',
        2 => '营业执照验证',
    ];

    const GOVID_PASS_EXAM = 1;
    const LICENSE_PASS_EXAM = 2;

    static $EXAMINE_STATUSES = [
        0 => '验证未通过',
        1 => '身份证已验证',
        2 => '营业执照已验证',
        1^2 => '验证通过',
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
            [['name'], 'required'],
            [['id', 'status', 'examined_by', 'user_id'], 'integer'],
            [['examined_time'], 'safe'],
            [['name', 'license_id', 'license_img'], 'string', 'max' => 500],
            [['name', 'license_id', 'license_img', 'contact_phone', 'contact_email', 'contact_name'], 'string', 'max' => 500],
            [['introduction'], 'string'],
            ['status', 'default', 'value'=>1],
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
            'introduction'=>'公司介绍',
            'license_id' => '营业执照号',
            'license_img' => '营业执照照片',
            'examined_time' => '审核日期',
            'examined_by' => '审核人',
            'status' => '状态',
            'user_id' => '用户',
            'contact_phone' => '联系电话',
            'contact_name' => '联系人',
            'contact_email' => '招聘邮箱'
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
}
