<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Task;

/**
 * TaskSearch represents the model behind the search form about `common\models\Task`.
 */
class TaskSearch extends Task
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'clearance_period','recommend', 'salary_unit', 'need_quantity', 'got_quantity', 'user_id', 'service_type_id', 'gender_requirement', 'degree_requirement', 'age_requirement', 'height_requirement', 'status', 'city_id','gid', 'company_id'], 'integer'],
            [['origin', 'title', 'salary_note', 'from_date', 'to_date', 'from_time', 'to_time', 'created_time', 'updated_time', 'detail', 'requirement'], 'safe'],
            [['salary'], 'number'],
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
        $query = Task::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder'=>['id'=>SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'gid' => $this->gid,
            'clearance_period' => $this->clearance_period,
            'recommend' => $this->recommend,
            'salary' => $this->salary,
            'salary_unit' => $this->salary_unit,
            'from_date' => $this->from_date,
            'to_date' => $this->to_date,
            'from_time' => $this->from_time,
            'to_time' => $this->to_time,
            'need_quantity' => $this->need_quantity,
            'got_quantity' => $this->got_quantity,
            'created_time' => $this->created_time,
            'updated_time' => $this->updated_time,
            'address' => $this->address,
            'user_id' => $this->user_id,
            'service_type_id' => $this->service_type_id,
            'gender_requirement' => $this->gender_requirement,
            'degree_requirement' => $this->degree_requirement,
            'age_requirement' => $this->age_requirement,
            'height_requirement' => $this->height_requirement,
            'status' => $this->status,
            'city_id' => $this->city_id,
            'origin' => $this->origin,
            'company_id' => $this->company_id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'salary_note', $this->salary_note])
            ->andFilterWhere(['like', 'detail', $this->detail])
            ->andFilterWhere(['like', 'requirement', $this->requirement]);

        return $dataProvider;
    }
}
