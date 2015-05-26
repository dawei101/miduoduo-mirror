<?php
namespace api\modules;

use Yii;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use yii\db\Query;


class BaseActiveController extends ActiveController
{

    static $QUERY_OPERATIONS = [
        "=",
        "!=",
        "<>",
        ">=",
        "<=",
        "LIKE",
        "ILIKE",
        "IN",
        "NOT IN",
    ];

    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    }

    protected function verbs()
    {
        $verbs = parent::verbs();
        $verbs['search'] = ['GET'];
        return $verbs;
    }

    public function prepareDataProvider()
    {
        return new ActiveDataProvider([
            'pagination' => [
                'pageSize' => 100,
            ],
            'query' => $this->buildQuery()
        ]);
    }

    public function buildQuery(){
        $model = $this->modelClass;
        $query = $model::find();
        $p_str = Yii::$app->request->getHeaders()->get('query');
        if (!$p_str || strlen($p_str)==0){
            return $query;
        }
        $conditions = json_decode($p_str);
        $p_dict = [];
        $where = '1 ';
        foreach ($conditions as $filter){
            $operate = strtoupper($filter[0]);
            if (!in_array($operate, static::$QUERY_OPERATIONS)){
                continue;
            }
            if(preg_match('/^[\w\d\_]+$/i', $filter[1])===0){
                continue;
            }
            if (strpos($operate, 'IN')!==false){
                // where(['in/not in', field, array])
                $query->where($filter);
            }
            $where .= ' AND ' . $filter[1] . ' ' . $filter[0] . ' :' . $filter[1] ;
            $p_dict[$filter[1]] = $filter[2];
        }
        $query->where($where, $p_dict);
        return $query;
    }

    public function renderJson($data)
    {
        header('Content-type: application/json');
        echo json_encode($data, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
        Yii::$app->end();
    }

}
