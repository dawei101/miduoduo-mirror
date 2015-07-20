<?php

namespace common\models;
use \DateTime;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\TaskApplicant;
use common\models\Task;

/**
 * TaskApplicantSearch represents the model behind the search form about `common\models\TaskApplicant`.
 */
class TaskApplicantSearch extends TaskApplicant
{
    public $task_title;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'task_id'], 'integer'],
            [['created_time'], 'date'],
            [['created_time','task_title'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = TaskApplicant::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder'=>['id'=>SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if ($this->created_time){
            $from_date = $this->created_time;
            $date = DateTime::createFromFormat('Y-m-d', $this->created_time);
            $to_date = $date->modify('+1 day')->format('Y-m-d');
            $query->andWhere(['>=', 'created_time', $from_date]);
            $query->andWhere(['<', 'created_time', $to_date]);
        }

        // 根据标题搜索特殊处理
        if( isset($this->task_title) && $this->task_title ){
            // 根据task_id（实际为任务名称），查询真正的task_id
            $task_m = Task::find()->where("`title` LIKE '%".$this->task_title."%'")->one();
            $this->task_id  = isset($task_m->id) ? $task_m->id : '';
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'task_id' => $this->task_id,
        ]);

        return $dataProvider;
    }
}
