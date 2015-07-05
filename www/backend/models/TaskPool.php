<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%task_pool}}".
 *
 * @property integer $id
 * @property string $company_name
 * @property string $city
 * @property string $origin_id
 * @property string $origin
 * @property double $lng
 * @property double $lat
 * @property string $details
 * @property integer $has_poi
 * @property integer $has_imported
 * @property string $created_time
 */
class TaskPool extends \common\BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%task_pool}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_name', 'origin_id', 'origin', 'details'], 'required'],
            [['lng', 'lat'], 'number'],
            [['details'], 'string'],
            [['has_poi', 'has_imported'], 'integer'],
            [['created_time'], 'safe'],
            [['company_name', 'city'], 'string', 'max' => 200],
            [['origin_id', 'origin'], 'string', 'max' => 45],
            [['origin_id', 'origin'], 'unique', 'targetAttribute' => ['origin_id', 'origin'], 'message' => 'The combination of 来源id and 来源 has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_name' => '公司名',
            'city' => '城市',
            'origin_id' => '来源id',
            'origin' => '来源',
            'lng' => 'Lng',
            'lat' => 'Lat',
            'details' => '细节',
            'has_poi' => '位置精准？',
            'has_imported' => 'Has Imported',
            'created_time' => 'Created Time',
        ];
    }

    /**
     * @inheritdoc
     * @return TaskPoolQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TaskPoolQuery(get_called_class());
    }
}
