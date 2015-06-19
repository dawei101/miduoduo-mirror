<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%offline_order}}".
 *
 * @property integer $id
 * @property string $gid
 * @property string $fee
 * @property integer $need_train
 * @property string $requirement
 * @property string $quality_requirement
 * @property integer $status
 * @property integer $created_by
 * @property integer $saleman_id
 * @property string $company
 * @property string $person_fee
 * @property string $from_date
 * @property string $to_date
 * @property integer $plan_quantity
 * @property integer $final_quantity
 * @property integer $plan_fee
 * @property integer $final_fee
 */
class OfflineOrder extends \common\BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%offline_order}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_by', 'from_date', 'to_date', 'plan_quantity', 'plan_fee'], 'required'],
            [['plan_fee'], 'number'],
            [['need_train', 'status', 'created_by', 'saleman_id', 'plan_quantity', 'final_quantity', 'plan_fee', 'final_fee'], 'integer'],
            [['requirement', 'quality_requirement'], 'string'],
            [['from_date', 'to_date'], 'safe'],
            [['gid'], 'string', 'max' => 1000],
            [['company'], 'string', 'max' => 500],
            [['person_fee'], 'string', 'max' => 100]
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
            'need_train' => '需要培训',
            'requirement' => '要求',
            'quality_requirement' => '质检要求',
            'status' => '状态',
            'created_by' => '创建人',
            'saleman_id' => '销售人',
            'company' => '公司名',
            'person_fee' => '单价额',
            'from_date' => '开始日期',
            'to_date' => '结束日期',
            'plan_quantity' => '计划人天时',
            'final_quantity' => '实际人天时',
            'plan_fee' => '计划费用',
            'final_fee' => '实际费用',
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
     * @return OfflineOrderQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OfflineOrderQuery(get_called_class());
    }

    public function getSaleman()
    {
        return $this->hasOne(User::className(), ['id' => 'saleman_id']);
    }


}
