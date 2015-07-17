<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%user_location}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $latitude
 * @property string $longitude
 * @property string $created_time
 * @property string $updated_time
 * @property integer $use_nums
 */
class UserLocation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_location}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'use_nums'], 'integer'],
            [['created_time', 'updated_time'], 'safe'],
            [['latitude', 'longitude'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '用户ID',
            'latitude' => '坐标纬度latitude',
            'longitude' => '坐标经度longitude',
            'created_time' => '创建时间',
            'updated_time' => '更新时间',
            'use_nums' => '位置使用次数',
        ];
    }
}
