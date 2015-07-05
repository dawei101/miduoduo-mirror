<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\TaskPoolWhiteList;

/**
 * TaskPoolWhiteListSearch represents the model behind the search form about `backend\models\TaskPoolWhiteList`.
 */
class TaskPoolWhiteListSearch extends TaskPoolWhiteList
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'examined_by'], 'integer'],
            [['company_name', 'examined_time', 'slug'], 'safe'],
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
        $query = TaskPoolWhiteList::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'examined_time' => $this->examined_time,
            'examined_by' => $this->examined_by,
        ]);

        $query->andFilterWhere(['like', 'company_name', $this->company_name])
            ->andFilterWhere(['like', 'slug', $this->slug]);

        return $dataProvider;
    }
}
