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
            [['has_poi', 'status'], 'integer'],
            [['created_time'], 'safe'],
            [['company_name', 'city'], 'string', 'max' => 200],
            [['origin_id', 'origin'], 'string', 'max' => 45],
            [['origin_id', 'origin'], 'unique', 'targetAttribute' => ['origin_id', 'origin'], 'message' => '已抓取过'],
            ['status', 'default', 'value'=>0],
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
            'status' => '状态',
            'status_label' => '状态',
            'created_time' => '创建时间',
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

    public function getStatus_options()
    {
        return [
            0=> '未处理',
            10=> '已导入',
            11=>'已放弃',
        ];
    }

    public function getStatus_label()
    {
        return $this->status_options[$this->status];
    }

    public function getOrigin_url()
    {
        if ($this->origin=='xiaolianbang'){
            return 'http://m.xiaolianbang.com/pt/' . $this->origin_id . '/detail';
        }
    }

    public function list_detail()
    {
        $s = [];
        foreach(json_decode($this->details) as $attr=>$value){
            $s[$attr] = $value ;
        }
        return $s;
    }
}
