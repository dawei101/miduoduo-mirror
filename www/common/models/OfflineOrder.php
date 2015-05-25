<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%offline_order}}".
 *
 * @property integer $id
 * @property string $gid
 * @property string $date
 * @property integer $worker_quntity
 * @property string $fee
 * @property integer $need_train
 * @property string $requirement
 * @property string $quality_requirement
 * @property integer $status
 * @property integer $created_by
 * @property integer $pm_id
 * @property integer $saleman_id
 * @property string $company
 * @property string $person_fee
 */
class OfflineOrder extends \common\BaseActiveRecord
{

    public static $STATUSES = [
        'DELETE' => 0,
        'ACTIVE' => 10,
    ];
    public static $STATUS_LABELS = [0=>'正常',
        10=>'已删除'];

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
            [['date'], 'safe'],
            [['worker_quntity', 'fee',  'date'], 'required'],
            [['worker_quntity', 'need_train', 'status', 'created_by', 'pm_id', 'saleman_id'], 'integer'],
            [['requirement', 'quality_requirement'], 'string'],
            [['gid'], 'string', 'max' => 1000],
            [['company'], 'string', 'max' => 500],
            [['fee'], 'double'],
            [['person_fee'], 'string', 'max' => 100],
            ['status', 'in', 'range'=>array_values(static::$STATUSES)],
            [['pm_id', 'saleman_id'], 'default', 'value'=>0],
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
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'gid' => '订单号',
            'person_fee' => '个人报酬',
            'date' => '日期',
            'worker_quntity' => '人数',
            'fee' => '服务金额',
            'need_train' => '需要培训',
            'requirement' => '要求',
            'quality_requirement' => '质检要求',
            'status' => '状态',
            'created_by' => '创建人',
            'pm_id' => '项目经理',
            'saleman_id' => '销售人',
            'company' => '公司名',
        ];
    }

    /**
     * @inheritdoc
     * @return OfflineOrderQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OfflineOrderQuery(get_called_class());
    }
}
