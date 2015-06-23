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
    public $modelClass = 'api\common\models\Task';

    public function actions()
    {
        $actions = parent::$actions;
        return ['index'=> $actions['index'], 'view'=> $action['view']];
    }
}
