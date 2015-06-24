<?php
 
namespace api\modules\v1\controllers;
 
use api\modules\BaseActiveController;
 
/**
 * Resume Controller API
 *
 * @author dawei
 */
class ResumeController extends BaseActiveController
{
    public $modelClass = 'api\common\models\Resume';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['delete'], $actions['create']);
    }

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
