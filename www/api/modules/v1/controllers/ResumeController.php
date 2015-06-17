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
        $as = parent::actions();
        unset($as['delete']);
        return $as;
    }

    public function buildBaseQuery()
    {
        $model = $this->modelClass;
        $query = $model::find()->where(['user_id'=>\Yii::$app->user->id]);
        return $query;
    }
}
