<?php
 
namespace api\modules\v1\controllers;
 
use api\modules\BaseActiveController;
 
/**
 * Resume Controller API
 *
 * @author dawei
 */
class FreetimeController extends BaseActiveController
{
    public $modelClass = 'common\models\Freetime';

    public $id_column = 'day_of_week';
    public $auto_filter_user = true;
    public $user_identifier_column = 'user_id';

    public $page_size = 10000;
}
