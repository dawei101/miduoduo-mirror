<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%suborder}}".
 *
 * @property integer $order_id
 * @property integer $address_id
 * @property string $date
 * @property string $from_time
 * @property string $to_time
 * @property integer $quantity
 * @property integer $got_qunatity
 * @property integer $modified_by
 * @property integer $pm_id
 */
class Suborder extends \common\BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%suborder}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'address_id', 'date', 'from_time', 'to_time', 'quantity'], 'required'],
            [['order_id', 'address_id', 'quantity', 'got_qunatity', 'modified_by', 'pm_id'], 'integer'],
            [['date', 'from_time', 'to_time'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_id' => '订单',
            'address_id' => '地址',
            'date' => '日期',
            'from_time' => '开始时间',
            'to_time' => '结束时间',
            'quantity' => '需人数',
            'got_qunatity' => '已有人数',
            'modified_by' => '修改人',
            'pm_id' => '项目经理',
        ];
    }

    /**
     * @inheritdoc
     * @return SuborderQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SuborderQuery(get_called_class());
    }

    public function beforeSave($insert) 
    { 
       if ($this->isNewRecord){ 
           $user_id = Yii::$app->user->id; 
           $this->modified_by = $user_id; 
       }
       return parent::beforeSave($insert); 
    }
}
