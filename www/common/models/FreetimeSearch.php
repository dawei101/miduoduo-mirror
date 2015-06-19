<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Freetime;

/**
 * FreetimeSearch represents the model behind the search form about `common\models\Freetime`.
 */
class FreetimeSearch extends Freetime
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'dayofweek', 'morning', 'afternoon', 'evening', 'user_id'], 'integer'],
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
        $query = Freetime::find();

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
            'dayofweek' => $this->dayofweek,
            'morning' => $this->morning,
            'afternoon' => $this->afternoon,
            'evening' => $this->evening,
            'user_id' => $this->user_id,
        ]);

        return $dataProvider;
    }
}
