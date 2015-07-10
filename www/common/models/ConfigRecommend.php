<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%config_recommend}}".
 *
 * @property integer $id
 * @property string $task_id
 * @property integer $type
 * @property integer $city_id
 * @property integer $display_order
 */
class ConfigRecommend extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%config_recommend}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'city_id', 'display_order'], 'integer'],
            [['task_id'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'task_id' => '任务gid',
            'type' => '类型',
            'city_id' => '城市ID',
            'display_order' => '排序，越大越靠前',
        ];
    }
}
