<?php
 
namespace api\modules\v1\controllers;
 
use api\modules\BaseActiveController;
use yii\web\ForbiddenHttpException;
 
/**
 * Address Controller API
 *
 * @author dawei
 */
class AddressController extends BaseActiveController
{
    public $modelClass = 'common\models\Address';

    public function buildBaseQuery()
    {
        $model = $this->modelClass;
        $query = $model::find()->where(['user_id'=>\Yii::$app->user->id]);
        return $query;
    }

    public function checkAccess($action, $model = null, $params = [])
    {
        if ($action=='view' && $model->user_id!=\Yii::$app->user->id){
            throw new ForbiddenHttpException('No access to view this address');
        }
        parent::checkAccess($action, $model, $params);
    }
}
