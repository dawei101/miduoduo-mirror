<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%freetime}}".
 *
 * @property integer $id
 * @property integer $dayofweek
 * @property integer $morning
 * @property integer $afternoon
 * @property integer $evening
 * @property integer $user_id
 */
class Freetime extends \common\BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%freetime}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dayofweek', 'user_id'], 'required'],
            [['dayofweek', 'morning', 'afternoon', 'evening', 'user_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'dayofweek' => '周几',
            'morning' => '上午',
            'afternoon' => '下午',
            'evening' => '晚上',
            'user_id' => 'User ID',
        ];
    }

    /**
     * @inheritdoc
     * @return FreetimeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FreetimeQuery(get_called_class());
    }
}
