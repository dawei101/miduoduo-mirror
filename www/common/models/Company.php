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
        0 => '未验证',
        1 => '验证失败',
        2 => '验证中',
        4 => '已冻结',

        8 => '身份证验证通过',
        8^(8<<1) => '营业执照验证通过',
    ];

    const STATUS_WAIT_EXAMINE = 0;
    const STATUS_EXAMINE_FAILED = 1;
    const STATUS_EXAMINEDING = 2;

    const STATUS_FREEZED = 4;

    const STATUS_GOVID_EXAMINED = 8;
    const STATUS_LICENSE = 8^(8<<1);
    const STATUS_EXAMINED = 8^(8<<1);
 

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
            ['status', 'default', 'value'=>0],
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
