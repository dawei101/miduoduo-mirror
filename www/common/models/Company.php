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
        5 => '已冻结',
        10 => '已删除',
        20 => '黑名单',
    ];

    const STATUS_OK = 0;
    const STATUS_FREEZED = 5;
    const STATUS_DELETED = 10;
    const STATUS_BLACKLISTED =20;

    static $EXAMINE_VALUES = [

        0 => '未验证',
        1 => '已开始验证',

        16 => '身份证验证通过',
        32 => '营业执照验证通过',
    ];

    const EXAM_GOVID_PASSED = 16;
    const EXAM_LICENSE_PASSED = 32;

    const EXAM_NOT_STARTED = 0;
    const EXAM_START = 1;

    public function getExamine_status()
    {
        $r = $this->exam_result;
        if ($r==EXAM_NOT_START){
            return static::$EXAMINE_VALUES[EXAM_NOT_START];
        } else {
            if ($r & 16 && $r & 32){
                return '通过验证';
            }
            if ($r & 16 && !($r & 32)){
                return '身份证通过验证'; // 营业执照未认证
            }
            if (!($r & 16) && $r & 32){
                return '营业执照通过验证';
            }
            if (!($r & 16) && !($r & 32)){
                return '认证未通过';
            }
        }
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
            [['name', 'license_id', 'license_img'], 'string', 'max' => 500],
            [['name', 'license_id', 'license_img', 'contact_phone', 'contact_email', 'contact_name'], 'string', 'max' => 500],
            [['introduction'], 'string'],
            ['contact_email', 'email'],
            ['status', 'default', 'value'=>1],
            ['contact_phone', 'match', 'pattern'=>'/^(1[345789]\d{9})|(0\d{2,3}\-?\d{7,8})$/',
                'message'=>'电话号码格式不正确.'],
            [['name', 'contact_name', 'contact_phone', 'contact_email'], 'required']
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
