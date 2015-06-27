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
 * @property integer $address_id
 * @property integer $examined_by
 * @property integer $user_id
 */
class Company extends \common\BaseActiveRecord
{
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
            [['id', 'name', 'license_id', 'license_img', 'user_id'], 'required'],
            [['id', 'status', 'address_id', 'examined_by', 'user_id'], 'integer'],
            [['examined_time'], 'safe'],
            [['name', 'license_id', 'license_img', 'contact_phone', 'contact_email'], 'string', 'max' => 500],
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
            'license_id' => '营业执照号',
            'license_img' => '营业执照',
            'examined_time' => '审核日期',
            'status' => '状态',
            'address_id' => '地址',
            'examined_by' => '审核人',
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

    public static function createCompanyWithCurrentUser(){
        $company = new Company;
        $company->user_id = Yii::$app->user->id;
        if ($company->save()){
            return $company;
        }
        return false;
    }

    public static function updateContactInfo($phone, $email)
    {
        $company = static::findByCurrentUser();
        if ($company === false) {
            //we build a company for first visit
            $company = static::createCompanyWithCurrentUser();
        }
        if ($company === false) {
            return false;
        }
        $company->contact_phone = $phone;
        $company->contact_email = $email;
        return $company->save();
    }
}
