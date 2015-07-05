<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%task_pool_white_list}}".
 *
 * @property integer $id
 * @property string $company_name
 * @property string $examined_time
 * @property string $slug
 * @property integer $examined_by
 */
class TaskPoolWhiteList extends \common\BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%task_pool_white_list}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_name', 'examined_by'], 'required'],
            [['examined_time'], 'safe'],
            [['examined_by'], 'integer'],
            [['company_name'], 'string', 'max' => 200],
            [['slug'], 'string', 'max' => 100],
            [['company_name'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_name' => 'Company Name',
            'examined_time' => 'Examined Time',
            'slug' => 'Slug',
            'examined_by' => 'Examined By',
        ];
    }

    /**
     * @inheritdoc
     * @return TaskPoolWhiteListQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TaskPoolWhiteListQuery(get_called_class());
    }
}
