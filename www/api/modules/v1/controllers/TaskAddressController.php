<?php
 
namespace api\modules\v1\controllers;
 
use api\modules\BaseActiveController;
use yii\web\ForbiddenHttpException;
 
/**
 * Address Controller API
 *
 * @author dawei
 */
class TaskAddressController extends BaseActiveController
{
    public $modelClass = 'common\models\TaskAddress';


    public $id_column = 'id';
    public $auto_filter_user = false;
}
