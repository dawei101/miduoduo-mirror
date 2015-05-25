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
            [['modified_by'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '服务种类',
            'created_time' => 'Created Time',
            'updated_time' => 'Updated Time',
            'modified_by' => '修改人',
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
