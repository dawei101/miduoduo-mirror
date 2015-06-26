<?php
 
namespace api\modules\v1\controllers;
 
use api\modules\BaseActiveController;
 
/**
 * Address Controller API
 *
 * @author dawei
 */
class TaskController extends BaseActiveController
{
    public $modelClass = 'common\models\Task';

    public $id_column = 'gid';

    public function actions()
    {
        $actions = parent::actions();
        return ['index'=> $actions['index'], 'view'=> $actions['view']];
    }
}
