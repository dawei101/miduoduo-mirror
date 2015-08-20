<?php

namespace common\models\extensions\time_book;

use Yii;

/**
 * This is the model class for table "ext_time_book_schedule".
 *
 * @property integer $id
 * @property string $user_id
 * @property string $task_id
 * @property string $from_datetime
 * @property string $to_datetime
 * @property integer $allowable_distance_offset
 * @property string $lat
 * @property string $lng
 *
 * @property Record[] $records
 */
class Schedule extends \common\BaseActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ext_time_book_schedule';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['from_datetime', 'to_datetime'], 'safe'],
            [['allowable_distance_offset'], 'integer'],
            [['lat', 'lng'], 'number'],
            [['date'], 'safe'],
            [['user_id', 'task_id'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'task_id' => 'Task ID',
            'from_datetime' => 'From Datetime',
            'to_datetime' => 'To Datetime',
            'allowable_distance_offset' => 'Allowable Distance Offset',
            'lat' => 'Lat',
            'lng' => 'Lng',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecords()
    {
        return $this->hasMany(Record::className(), ['schedule_id' => 'id']);
    }
}
