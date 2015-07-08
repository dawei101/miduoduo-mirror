<?php
 
namespace api\modules\v1\controllers;
 
use api\modules\BaseActiveController;

use common\models\UserReadedSysMessage;
 
/**
 * Sys Message Controller API
 *
 * @author dawei
 */
class SysMessageController extends BaseActiveController
{
    public $modelClass = 'common\models\SysMessage';

    public $id_column = 'id';

    public function actions()
    {
        $actions = parent::actions();
        return ['index'=> $actions['index'], 'view'=> $actions['view']];
    }

    public function buildBaseQuery()
    {
        $query = parent::buildBaseQuery();
        $query->andWhere(['>=', 'created_time', \Yii::$app->user->identity->created_time]);
        return $query;
    }

    public function actionUpdate($id)
    {
        $flag = UserReadedSysMessage();
        $flag->sys_message_id = $id;
        $flag = \Yii::$app->user->id;
        if ($model->save() === false && !$model->hasErrors())
        {
            throw new ServerErrorHttpException('Failed to update the object for unknown reason.');
        }
        return model;
    }
}