<?php

namespace backend\models;

use backend\models\TaskPoolWhiteList;

use Yii;

/**
 * This is the model class for table "{{%task_pool_white_list}}".
 *
 * @property integer $id
 * @property string $origin
 * @property string $attr
 * @property string $value
 * @property string $examined_time
 * @property string $slug
 * @property integer $examined_by
 * @property integer $is_white
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
            [['origin', 'attr', 'value', 'examined_by'], 'required'],
            [['examined_time'], 'safe'],
            [['examined_by', 'is_white'], 'integer'],
            [['origin', 'attr', 'value'], 'string', 'max' => 200],
            [['slug'], 'string', 'max' => 100],
            [['origin', 'attr', 'value'], 'unique', 'targetAttribute' => ['origin', 'attr', 'value'], 'message' => 'The combination of Origin, Attr and Value has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'origin' => '来源',
            'attr' => '属性',
            'value' => 'Value',
            'examined_time' => '审核日期',
            'slug' => '大鼻涕',
            'examined_by' => '审核人',
            'is_white' => '白名单?',
            'type' => '类型',
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

    public function getType()
    {
        return $this->is_white?'白名单':'黑名单';
    }

    public function examineTaskPool()
    {
        $conditions = [
                $this->attr=>$this->value,
                'origin'=>$this->origin,
                'status'=>0
            ];
        if ($this->is_white){
            $ws = TaskPool::findAll($conditions);
            $tasks = [];
            foreach ($ws as $w){
                $task = $w->exportTask();
                $tasks[] = $task;
            }
            TaskPool::updateAll(['status'=>10], $conditions);
            return $tasks;
        } else {
            TaskPool::updateAll(['status'=>11], $conditions);
        }
    }

}
