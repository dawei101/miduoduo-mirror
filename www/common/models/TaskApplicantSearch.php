<?php

namespace common\models;
use \DateTime;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\TaskApplicant;


/**
 * TaskApplicantSearch represents the model behind the search form about `common\models\TaskApplicant`.
 */
class TaskApplicantSearch extends TaskApplicant
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'task_id'], 'integer'],
            [['created_time'], 'date'],
            [['created_time'], 'safe'],
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

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'task_id' => $this->task_id,
        ]);

        return $dataProvider;
    }
}
