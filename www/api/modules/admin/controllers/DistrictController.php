<?php
 
namespace api\modules\v1\controllers;
 
use api\modules\BaseActiveController;
use yii\web\ForbiddenHttpException;
use yii\data\ActiveDataProvider;
 
/**
 * District Controller API
 *
 * @author dawei
 */
class DistrictController extends BaseActiveController
{
    public $modelClass = 'common\models\District';

    public function actions()
    {
        $actions = parent::actions();
        return ['index' => $actions['index']];
    }

    public $id_column = 'id';

    public $page_size = 10000;

}
