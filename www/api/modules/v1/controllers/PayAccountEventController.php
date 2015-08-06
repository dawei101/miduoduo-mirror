<?php
 
namespace api\modules\v1\controllers;

use Yii;
use api\modules\BaseActiveController;
use common\Utils;
use common\models\AccountEvent;
use common\models\WithdrawCash;
use common\payment\Pay;
 
/**
 * PayAccountEvent Controller API
 *
 * @author suibber
 */
class PayAccountEventController extends BaseActiveController
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
        $status     = Yii::$app->request->get('status');
        
        if( $status == WithdrawCash::STATUS_UNKNOW ){
            $records   = AccountEvent::find()
                ->where(['user_id'=>$user_id , 'related_id'=>''])
                ->all();
        }elseif( $status == WithdrawCash::STATUS_SUCCESS ){
            $records  = WithdrawCash::find()
                ->where(['`jz_withdraw_cash`.user_id'=>$user_id , '`jz_withdraw_cash`.status'=>$status])
                ->with('accountEvent')
                ->all();

            $new_records    = '';
            foreach( $records as $k => $v ){
                foreach( $v->accountEvent as $k2 => $v2 ){
                    $new_records[]  = $v2;
                }
            }
            $records    = $new_records;
        }

        $pay    = new Pay();
        $money_all      = $pay->getMoneyAll($user_id);
        $money_balance  = $pay->getMoneyBalance($user_id);
        $money_success  = $pay->getMoneySuccess($user_id);
        $money_doing    = $pay->getMoneyDoing($user_id);
        $money  = [
            'money_all'       => $money_all,
            'money_balance'   => $money_balance,
            'money_success'   => $money_success,
            'money_doing'     => $money_doing, 
        ];

        return ['data' => $records, 'money' => $money];
    }

}