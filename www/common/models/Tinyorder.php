<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%tinyorder}}".
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $address_id
 * @property integer $user_id
 * @property integer $added_by
 * @property integer $status
 */
class Tinyorder extends \common\BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tinyorder}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'order_id', 'address_id', 'user_id', 'added_by'], 'required'],
            [['id', 'order_id', 'address_id', 'user_id', 'added_by', 'status'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => '订单号',
            'address_id' => '地址',
            'user_id' => '用户',
            'added_by' => '添加人',
            'status' => '状态',
        ];
    }

    /**
     * @inheritdoc
     * @return TinyorderQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TinyorderQuery(get_called_class());
    }
}
