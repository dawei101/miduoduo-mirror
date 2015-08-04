<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%withdraw_cash}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $value
 * @property string $withdraw_time
 * @property integer $type
 * @property integer $payout_id
 * @property integer $status
 * @property string $updated_time
 * @property string $note
 */
class WithdrawCash extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%withdraw_cash}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'type', 'payout_id', 'status'], 'integer'],
            [['value', 'type', 'status'], 'required'],
            [['value'], 'number'],
            [['withdraw_time', 'updated_time'], 'safe'],
            [['note'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'user_id' => '用户id',
            'value' => '金额',
            'withdraw_time' => '提现时间',
            'type' => '打款方式',
            'payout_id' => '打款明细',
            'status' => '状态',
            'updated_time' => '最后更改时间',
            'note' => '备注',
        ];
    }
}
