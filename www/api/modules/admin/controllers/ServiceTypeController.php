<?php
 
namespace api\modules\v1\controllers;
 
use api\modules\BaseActiveController;
 
/**
 * Address Controller API
 *
 * @author dawei
 */
class ServiceTypeController extends BaseActiveController
{
    public $modelClass = 'common\models\ServiceType';

    public $id_column = 'id';

    public function actions()
    {
        $actions = parent::actions();
        return ['index'=> $actions['index'], 'view'=> $actions['view']];
    }
}