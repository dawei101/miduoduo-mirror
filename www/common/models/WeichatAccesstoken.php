<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%weichat_accesstoken}}".
 *
 * @property integer $id
 * @property string $access_token
 * @property integer $expires_in
 * @property string $created_time
 * @property string $update_time
 * @property integer $used_times
 */
class WeichatAccesstoken extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%weichat_accesstoken}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['expires_in', 'used_times'], 'integer'],
            [['created_time', 'update_time'], 'safe'],
            [['access_token'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'access_token' => '微信的access_token',
            'expires_in' => '过期时间',
            'created_time' => '创建时间',
            'update_time' => '更新时间',
            'used_times' => '使用次数',
        ];
    }
}
