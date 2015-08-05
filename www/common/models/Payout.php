<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%payout}}".
 *
 * @property integer $id
 * @property string $gid
 * @property string $payout_time
 * @property string $value
 * @property integer $type
 * @property string $account_id
 * @property string $account_owner
 * @property integer $to_user_id
 * @property integer $status
 * @property integer $operator_id
 * @property string $created_time
 * @property string $note
 */
class Payout extends \yii\db\ActiveRecord
{
    public static $STATUS   = [
        0   => '未知',
        1   => '申请',
        2   => '结算中',
        3   => '提现完成',
        4   => '提现失败'
    ];

    const STATUS_UNKNOW = 0;
    const STATUS_APPLY  = 1;
    const STATUS_DOING  = 2;
    const STATUS_SUCCESS= 3;
    const STATUS_FAULT  = 4;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%payout}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gid', 'value', 'type', 'account_id', 'to_user_id', 'status', 'operator_id'], 'required'],
            [['payout_time', 'created_time'], 'safe'],
            [['value'], 'number'],
            [['type', 'to_user_id', 'status', 'operator_id'], 'integer'],
            [['note'], 'string'],
            [['gid'], 'string', 'max' => 200],
            [['account_id'], 'string', 'max' => 500],
            [['account_owner'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'gid' => '第三方流水号',
            'payout_time' => '支付时间',
            'value' => '支付金额',
            'type' => '打款方式 微信（线上） 银行卡（线下）',
            'account_id' => '收款账号',
            'account_owner' => '收款人',
            'to_user_id' => '收款用户id',
            'status' => '结果',
            'operator_id' => '操作人',
            'created_time' => '录入时间',
            'note' => 'Note',
        ];
    }
}
