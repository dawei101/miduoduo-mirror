<?php
 
namespace api\modules\v1\controllers;
 
use api\modules\BaseActiveController;
 
/**
 * Sys Message Controller API
 *
 * @author dawei
 */
class MessageController extends BaseActiveController
{
    public $modelClass = 'common\models\Message';

    public $id_column = 'id';
    public $auto_filter_user = true;
    public $user_identifier_column = 'user_id';

    public function actions()
    {
        $actions = parent::actions();
        return ['index'=> $actions['index'], 'view'=> $actions['view']];
    }

    public function actionUpdate($id)
    {
        $m = $this->buildBaseQuery()->andWhere(['id'=>id]);
        if (!$m){
            throw new HttpException(404, 'Record not found');
        }
        $m->read_flag = true;
        $m->save();
        return $m;
    }
}
