<?php
 
namespace api\modules\v1\controllers;
 
use api\modules\BaseActiveController;
 
/**
 * Address Controller API
 *
 * @author dawei
 */
class AddressController extends BaseActiveController
{
    public $modelClass = 'common\models\Address';

    public function buildBaseQuery()
    {
        $query = parent::buildBaseQuery();
        return $query->with('user');
    }



}
