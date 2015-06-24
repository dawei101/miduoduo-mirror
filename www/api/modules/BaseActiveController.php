<?php
namespace api\modules;

use Yii;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use yii\db\Query;
use yii\web\Response;


class BaseActiveController extends ActiveController
{

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'corsFilter' => [
                'class' => \yii\filters\Cors::className(),
                'cors' => [
                    'Origin' => Yii::$app->params['api_allowed_origins'], 
                    'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                    'Access-Control-Request-Headers' => ['*'],
                    'Access-Control-Allow-Credentials' => null,
                    'Access-Control-Max-Age' => 86400,
                    'Access-Control-Expose-Headers' => [],
                ],
            ],
        ]); 
    }

    public $serializer=[
        'class'=>'yii\rest\Serializer',
        'collectionEnvelope'=>'items',
    ];

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
            'query' => $this->buildQuery()
        ]);
    }

    public function buildQuery(){
        $query = $this->buildBaseQuery();
        $p_str = Yii::$app->request->get('filters');

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
                $query->andWhere($filter);
                continue;
            }
            $where .= ' AND ' . $filter[1] . ' ' . $filter[0] . ' :' . $filter[1] ;
            $p_dict[$filter[1]] = $filter[2];
        }
        $query->andWhere($where, $p_dict);
        return $query;
    }

    public function buildBaseQuery()
    {
        $model = $this->modelClass;
        $query = $model::find();
        return $query;
    }

    public function renderJson($data)
    {
        header('Content-type: application/json');
        echo json_encode($data, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
        Yii::$app->end();
    }
}
