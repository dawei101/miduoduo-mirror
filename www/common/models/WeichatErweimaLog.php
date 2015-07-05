<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%weichat_erweima_log}}".
 *
 * @property integer $id
 * @property integer $erweima_id
 * @property string $openid
 * @property string $create_time
 * @property integer $has_bind
 * @property integer $follow_by_scan
 */
class WeichatErweimaLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%weichat_erweima_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['erweima_id', 'has_bind', 'follow_by_scan'], 'integer'],
            [['create_time'], 'safe'],
            [['openid'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'erweima_id' => '对应的二维码ID',
            'openid' => '扫描关注者的微信id',
            'create_time' => '创建时间',
            'has_bind' => '扫描之前是否已经绑定过',
            'follow_by_scan' => '是否通过扫描关注公众号',
        ];
    }
}
