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
            [['name'], 'required'],
            [['id', 'status', 'examined_by', 'user_id'], 'integer'],
            [['examined_time'], 'safe'],
            [['name', 'license_id', 'license_img'], 'string', 'max' => 500],
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
            'user_id' => '用户',
            'status' => '状态',
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
}
