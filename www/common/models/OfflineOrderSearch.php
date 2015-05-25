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
            [['id', 'worker_quntity', 'need_train', 'status', 'created_by', 'pm_id', 'saleman_id'], 'integer'],
            [['gid', 'date', 'requirement', 'quality_requirement', 'company', 'person_fee'], 'safe'],
            [['fee'], 'number'],
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
            'date' => $this->date,
            'worker_quntity' => $this->worker_quntity,
            'fee' => $this->fee,
            'need_train' => $this->need_train,
            'status' => $this->status,
            'created_by' => $this->created_by,
            'pm_id' => $this->pm_id,
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
