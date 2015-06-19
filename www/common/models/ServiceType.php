<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%service_type}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $created_time
 * @property string $updated_time
 * @property string $modified_by
 * @property smallint $status
 */
class ServiceType extends \common\BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%service_type}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['created_time', 'updated_time'], 'safe'],
            [['name'], 'string', 'max' => 200],
            [['modified_by'], 'string', 'max' => 45],
            ['status', 'default', 'value'=>0]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '服务类型',
            'created_time' => '创建时间',
            'updated_time' => '修改时间',
            'modified_by' => '修改人',
            'status' => '状态',
        ];
    }

    /**
     * @inheritdoc
     * @return ServiceTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ServiceTypeQuery(get_called_class());
    }
}
