<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Suborder;

/**
 * SuborderSearch represents the model behind the search form about `common\models\Suborder`.
 */
class SuborderSearch extends Suborder
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'address_id', 'quantity', 'got_qunatity', 'modified_by'], 'integer'],
            [['from_time', 'to_time'], 'safe'],
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
        $query = Suborder::find();

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
            'order_id' => $this->order_id,
            'address_id' => $this->address_id,
            'from_time' => $this->from_time,
            'to_time' => $this->to_time,
            'quantity' => $this->quantity,
            'got_qunatity' => $this->got_qunatity,
            'modified_by' => $this->modified_by,
        ]);

        return $dataProvider;
    }
}
