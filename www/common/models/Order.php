<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\web\IdentityInterface;



/**
 * Order model
 *
 * @property integer $id
 * @property integer $gid
 * @property integer $date
 * @property decimal(10, 2) $fee
 * @property integer $worker_quantity
 * @property bool $need_train
 * @property string $requirement
 * @property string $quality_requirement
 * @property integer $saleman_id
 * @property integer $pm_id // 质量管控
 * @property integer $supervisor_id
 * @property integer $created_by
 *
 * @property integer $created_time
 * @property integer $updated_time
 *
 * @property smallint $status
 */

class OfflineOrder extends BaseActiveRecord
{

    public static $STATUSES = [
        0=> '等待审核',
        1=> '等待派单',
        2=> '进行中',
        3=> '完成',
    ];

    public static function tableName()
    {
        return 'jz_offline_orders';
    }

    public function rules() {
        return [
            [['id', 'date', 'created_time', 'updated_time',
                'pm_id', 'saleman_id', 'supervisor_id',
                'created_by', 'worker_quantity'], 'integer'],
            [['requirement', 'quality_requirement'], 'string'],
            [['status'], 'in', 'range'=>static::$STATUSES],
            [['worker_quantity', 'fee'], 'require']
        ];
    }

    public function behaviors(){
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_time',
                'updatedAtAttribute' => 'updated_time',
                'value' => new Expression('NOW()'),
            ],
        ];
    }

}
