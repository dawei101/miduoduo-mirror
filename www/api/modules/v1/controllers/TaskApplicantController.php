<?php
 
namespace api\modules\v1\controllers;
 
use api\modules\BaseActiveController;
 
/**
 *  Controller API
 *
 * @author dawei
 */
class TaskApplicantController extends BaseActiveController
{
    public $modelClass = 'common\models\TaskApplicant';

    public $id_column = 'task_id';
    public $auto_filter_user = true;
    public $user_identifier_column = 'user_id';
}
