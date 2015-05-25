<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\OfflineOrder;

/**
 * OfflineOrderSeearch represents the model behind the search form about `common\models\OfflineOrder`.
 */
class OfflineOrderSeearch extends OfflineOrder
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'worker_quntity', 'need_train', 'status', 'pm_id', 'supervisor_id', 'saleman_id', 'created_by'], 'integer'],
            [['gid', 'date', 'requirement', 'quality_requirement', 'created_time', 'updated_time'], 'safe'],
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
            'need_train' => $this->need_train,
            'created_time' => $this->created_time,
            'updated_time' => $this->updated_time,
            'status' => $this->status,
            'fee' => $this->fee,
            'pm_id' => $this->pm_id,
            'supervisor_id' => $this->supervisor_id,
            'saleman_id' => $this->saleman_id,
            'created_by' => $this->created_by,
        ]);

        $query->andFilterWhere(['like', 'gid', $this->gid])
            ->andFilterWhere(['like', 'requirement', $this->requirement])
            ->andFilterWhere(['like', 'quality_requirement', $this->quality_requirement]);

        return $dataProvider;
    }
}
