<?php
namespace api\modules;

use Yii;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use yii\db\Query;
use yii\web\Response;
use yii\web\HttpException;


class BaseActiveController extends ActiveController
{

    public $serializer = [
        'class'=>'yii\rest\Serializer',
        'collectionEnvelope'=>'items',
    ];

    // 设置url中id所对应的字段
    public $id_column = 'id';

    //设置是否自动限定只访问自己的数据
    public $auto_filter_user = false;

    //标识用户的字段, 用此字段对应user_id
    public $user_identifier_column = null;

    // null = 使用默认
    public $page_size = null;

    public function beforeAction($action)
    {
        if ($action->id == 'create'){
            if ($this->auto_filter_user && $this->user_identifier_column){
                $params = Yii::$app->getRequest()->getBodyParams();
                $params[$this->user_identifier_column] = Yii::$app->user->id;
                Yii::$app->getRequest()->setBodyParams($params);
            }
        }
        return parent::beforeAction($action);
    }

    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        $actions['view']['findModel'] = [$this, 'findModel'];
        $actions['update']['findModel'] = [$this, 'findModel'];
        $actions['delete']['findModel'] = [$this, 'findModel'];

        return $actions;
    }

    public function findModel($id)
    {
        $model = $this->modelClass;
        $tc = $this->buildBaseQuery()->andWhere([$this->id_column=>$id])->one();
        if (!$tc){
            throw new HttpException(404, 'Record not found');
        }
        return $tc;
    }

    public function buildBaseQuery()
    {
        $model = $this->modelClass;
        $query = $model::find();
        if ($this->auto_filter_user && $this->user_identifier_column){
            if (\Yii::$app->user->isGuest){
                throw new ForbiddenHttpException("Unknown user");
            }
            $query->where([$this->user_identifier_column=>\Yii::$app->user->id]);
        }
        return $query;
    }

    public function checkAccess($action, $model = null, $params = [])
    {
        if ($this->auto_filter_user && $this->user_identifier_column){
            if (\Yii::$app->user->isGuest){
                throw new ForbiddenHttpException("Unknown user");
            }
            if ($action=='view' && $model->user_id!=\Yii::$app->user->id){
                throw new ForbiddenHttpException("No access");
            }
        }
        parent::checkAccess($action, $model, $params);
    }

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'corsFilter' => [
                'class' => \yii\filters\Cors::className(),
                'cors' => [
                    'Origin' => ['*'], 
                    'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                    'Access-Control-Request-Headers' => ['*'],
                    'Access-Control-Allow-Credentials' => null,
                    'Access-Control-Max-Age' => 86400,
                    'Access-Control-Expose-Headers' => [],
                ],
            ],
        ]); 
    }

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

    protected function verbs()
    {
        $verbs = parent::verbs();
        $verbs['search'] = ['GET'];
        return $verbs;
    }

    public function prepareDataProvider()
    {
        if ($this->page_size){
            return new ActiveDataProvider([
                'query' => $this->buildFilterQuery(),
                'pagination' => ['pageSize' => $this->page_size ],
            ]);
        }
        return new ActiveDataProvider([
            'query' => $this->buildFilterQuery()
        ]);

    }

    public function buildFilterQuery(){
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

    public function renderJson($data)
    {
        header('Content-type: application/json');
        echo json_encode($data, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
        Yii::$app->end();
    }
}
