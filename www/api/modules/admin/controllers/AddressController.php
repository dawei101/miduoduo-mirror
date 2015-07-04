<?php
 
namespace api\modules\v1\controllers;
 
use api\modules\BaseActiveController;
use yii\web\ForbiddenHttpException;
 
/**
 * Address Controller API
 *
 * @author dawei
 */
class AddressController extends BaseActiveController
{
    public $modelClass = 'common\models\Address';

    public $id_column = 'id';
    public $auto_filter_user = true;
    public $user_identifier_column = 'user_id';

}
