<?php
namespace corp;

use Yii;
use common\BaseController;

class CBaseController extends BaseController
{
    public function renderJson($data)
    {
        header('Content-type: application/json');
        echo json_encode($data, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
        Yii::$app->end();
    }
}
