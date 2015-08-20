<?php

namespace common\models\extensions\time_book;

use Yii;

/**
 * This is the model class for table "ext_time_book_record".
 *
 * @property integer $id
 * @property string $lng
 * @property string $lat
 * @property integer $event_type
 * @property string $created_time
 * @property string $user_id
 * @property integer $schedule_id
 *
 * @property Schedule $schedule
 */
class Record extends \common\BaseActiveRecord
{

    const EVENT_ON = 1;
    const EVENT_OFF = 2;

    public static function tableName()
    {
        return 'ext_time_book_record';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'lng', 'lat', 'schedule_id'], 'required'],
            [['id', 'event_type', 'schedule_id'], 'integer'],
            [['lng', 'lat'], 'number'],
            [['created_time'], 'safe'],
            [['user_id'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lng' => 'Lng',
            'lat' => 'Lat',
            'event_type' => 'Event Type',
            'created_time' => 'Created Time',
            'user_id' => 'User ID',
            'schedule_id' => 'Schedule ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSchedule()
    {
        return $this->hasOne(Schedule::className(), ['id' => 'schedule_id']);
    }

}
