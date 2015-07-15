<?php

namespace common\models;

use Yii;

use common\models\User;
use common\models\Task;

/**
 * This is the model class for table "{{%task_address}}".
 *
 * @property integer $id
 * @property string $province
 * @property string $city
 * @property string $district
 * @property double $lat
 * @property double $lng
 * @property integer $task_id
 * @property integer $user_id
 */
class TaskAddress extends \common\BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%task_address}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lat', 'lng', 'task_id'], 'required'],
            [['lat', 'lng'], 'number'],
            [['task_id', 'user_id'], 'integer'],
            [['province', 'city', 'district'], 'string', 'max' => 45],
            [['address', 'title'], 'string', 'max' => 200],
            ['user_id', 'default', 'value'=> 0],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'province' => '省',
            'city' => '市',
            'district' => '区/县',
            'lat' => '经度',
            'lng' => '纬度',
            'task_id' => '任务',
            'user_id' => '用户',
        ];
    }

    /**
     * @inheritdoc
     * @return TaskAddressQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TaskAddressQuery(get_called_class());
    }

    public function getTask()
    {
        return $this->hasOne(Task::className(), ['id' => 'task_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function extraFields()
    {
        return ['task', 'user'];
    }

    public static function buildNearbyQuery($query, $lat, $lng, $distance)
    {
        $max_d = Yii::$app->params['nearby_search.max_distance'];
        $distance = min([$max_d, $distance]);
        $lat_col = static::tableName() . '.lat';
        $lng_col = static::tableName() . '.lng';
        $mpi = pi();
        $lat_range = 180.0/$mpi*($distance/1000.0)/6372.797;
        $lng_range = $lat_range/cos($lat*$mpi/180.0);
        $max_lat = $lat + $lat_range;
        $min_lat = $lat - $lat_range;
        $max_lng = $lng + $lng_range;
        $min_lng = $lng - $lng_range;
        $query
            ->andWhere(['>', $lat_col, $min_lat])
            ->andWhere(['<', $lat_col, $max_lat])
            ->andWhere(['>', $lng_col, $min_lng])
            ->andWhere(['<', $lng_col, $max_lng]);
        return $query;
    }



}
