<?php
 
namespace api\modules\v1\controllers;

use api\modules\BaseActiveController;

/**
 * Controller API
 *
 * @author dawei
 */
class ComplaintController extends BaseActiveController
{
    public $modelClass = 'common\models\Complaint';

    public $id_column = 'id';

    public $auto_filter_user = true;
    public $user_identifier_column = 'user_id';

}
