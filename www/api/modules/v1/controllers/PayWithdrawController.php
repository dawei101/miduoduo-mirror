<?php
 
namespace api\modules\v1\controllers;

use Yii;
use api\modules\BaseActiveController;
use common\Utils;
use common\models\AccountEvent;
use common\models\WithdrawCash;
use common\payment\Pay;
 
/**
 * PayWithdrawController API
 *
 * @author suibber
 */
class PayWithdrawController extends BaseActiveController
{
    public $modelClass = 'common\models\AccountEvent';

    public $id_column  = 'user_id';

    public $auto_filter_user = true;
    public $user_identifier_column = 'user_id';

    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    }

    public function prepareDataProvider()
    {
        $user_id    = \Yii::$app->user->id;
        $pay_type   = Yii::$app->request->get('type');

        if( $user_id ){
            $pay        = new Pay();
            $result     = $pay->withdrawAllBalance($user_id,$pay_type);            
        }else{
            $result    = '{ "success": false, "message": 发生错误 }';
        }
        return $result;
    }
}