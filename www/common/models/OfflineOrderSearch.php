<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\OfflineOrder;

/**
 * OfflineOrderSearch represents the model behind the search form about `common\models\OfflineOrder`.
 */
class OfflineOrderSearch extends OfflineOrder
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'plan_quantity', 'final_quantity',
                    'need_train', 'status', 'created_by',
                    'saleman_id'],
                'integer'],
            [['gid', 'from_date', 'to_date', 'requirement', 'quality_requirement', 'company', 'person_fee'], 'safe'],
            [['plan_fee', 'final_fee'], 'number'],
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
        $query = OfflineOrder::find();

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
            'from_date' => $this->from_date,
            'to_date' => $this->to_date,
            'plan_quantity' => $this->plan_quantity,
            'final_quantity' => $this->final_quantity,
            'plan_fee' => $this->plan_fee,
            'final_fee' => $this->final_fee,
            'need_train' => $this->need_train,
            'status' => $this->status,
            'created_by' => $this->created_by,
            'saleman_id' => $this->saleman_id,
        ]);

        $query->andFilterWhere(['like', 'gid', $this->gid])
            ->andFilterWhere(['like', 'requirement', $this->requirement])
            ->andFilterWhere(['like', 'quality_requirement', $this->quality_requirement])
            ->andFilterWhere(['like', 'company', $this->company])
            ->andFilterWhere(['like', 'person_fee', $this->person_fee]);

        return $dataProvider;
    }
}
