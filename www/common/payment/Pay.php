<?php
namespace common\payment;

use Yii;
use yii\base\Component;
use common\models\WithdrawCash;
use common\models\Payout;
use common\payment\WechatPayment;
use common\WeichatBase;
use common\models\AccountEvent;

class Pay extends Component
{
    public function withdrawAllBalance( $user_id , $pay_type ){
        $account_data   = AccountEvent::find()
                ->where(['user_id'=>$user_id , 'related_id'=>''])
                ->asArray()
                ->all();

        if( count($account_data) ){
            if( $pay_type == WithdrawCash::TYPES_WECAHT ){
                $withdraw_result  = $this->withdrawByWechat($account_data,$user_id);
            }else{
                $error_message = '提款失败，目前只支持微信提款';
            }
        }else{
            $error_message = '提款失败，您的账户余额为空';
        }

        if( isset($withdraw_result['withdraw_id']) ){
            // 更新资金流水
            $accountevent   = new AccountEvent();
            $accountevent->updateAll(
                ['related_id'=>$withdraw_result['withdraw_id']],
                '`id` in ('.$withdraw_result['count_ids'].')'
            );
            $result   = "{ 'success': true , 'value': ".$withdraw_result['count_value']." , 'message': 提现成功 }";
        }else{
            $error_message  = isset($withdraw_result['error_message']) ? $withdraw_result['error_message'] : $error_message;
            $result   = "{ 'success': false , 'value': 0 , 'message': ".$error_message." }";
        }
        return $result;
    }

    // 微信提款
    public function withdrawByWechat($account_data,$user_id){
        $count_value    = 0;
        $count_ids      = '';
        foreach( $account_data as $k => $v ){
            $count_value += $v['value'];
            $count_ids   .= $v['id'].',';
        }
        $count_ids      = trim($count_ids,',');
        $date_time      = date("Y-m-d H:i:s");
        $payout_return  = $this->payOutByWechat($user_id,$count_value,$date_time);

        $withdraw   = new WithdrawCash();
        $withdraw->user_id          = $user_id;
        $withdraw->value            = $count_value;
        $withdraw->withdraw_time    = $date_time;
        $withdraw->type             = $withdraw::TYPES_WECAHT;
        $withdraw->payout_id        = $payout_return['payout_id'];
        $withdraw->status           = $payout_return['status'];
        $withdraw->updated_time     = $date_time;
        $withdraw->operator_id      = $user_id;
        $withdraw->save();
        if( $payout_return['status'] == Payout::STATUS_SUCCESS ){
            return [
                'withdraw_id' => $withdraw->id,
                'count_value' => $count_value,
                'count_ids' => $count_ids,
            ];
        }else{
            $error_message  = '提款失败，请联系我们';
            return ['error_message' => $error_message];
        }
    }

    // 微信支付
    public function payOutByWechat($user_id,$count_value,$date_time){
        $weichatbase= new WeichatBase();
        $wechat_id  = $weichatbase->getLoggedUserWeichatID($user_id);
        $gid        = $wechat_id . time();

        $payment    = new WechatPayment;
        $pay_result = $payment->payout($wechat_id, $count_value, $gid, '工资提现');

        $payout     = new Payout();
        if( $pay_result ){
            $payout_status  = Payout::STATUS_SUCCESS;
            $withdraw_status= WithdrawCash::STATUS_SUCCESS;
        }else{
            $payout_status  = Payout::STATUS_FAULT;
            $withdraw_status= WithdrawCash::STATUS_FAULT;
        }
        $payout->gid            = $gid;
        $payout->payout_time    = $date_time;
        $payout->value          = $count_value;
        $payout->type           = WithdrawCash::TYPES_WECAHT;
        $payout->account_id     = $wechat_id;
        $payout->account_owner  = $wechat_id;
        $payout->to_user_id     = $user_id;
        $payout->status         = $payout_status;
        $payout->operator_id    = $user_id;
        $payout->created_time   = $date_time;
        $payout->account_info   = '';
        $payout->save();
        
        $payout_return  = [
            'status'    => $withdraw_status,
            'payout_id' => $payout->id, 
        ];
        return $payout_return;
    }

    // 支付宝提款
    public function withdrawByAlipay($account_data,$user_id){}
    public function payOutByAlipay(){}


    // 银行卡提款
    public function withdrawByBank($account_data,$user_id){}
    public function payOutByBank(){}

    public function getMoneyAll( $user_id ){
        $money  = AccountEvent::find()
            ->where(['user_id'=>$user_id])
            ->sum('value');
        $money  = $money ? $money : 0;
        return $money;
    }

    public function getMoneyBalance( $user_id ){
        $money  = AccountEvent::find()
            ->where(['user_id'=>$user_id,'related_id'=>''])
            ->sum('value');
        $money  = $money ? $money : 0;
        return $money;
    }

    public function getMoneySuccess( $user_id ){
        $money  = WithdrawCash::find()
            ->where(['user_id'=>$user_id,'status'=>WithdrawCash::STATUS_SUCCESS])
            ->sum('value');
        $money  = $money ? $money : 0;
        return $money;
    }

    public function getMoneyDoing( $user_id ){
        $money  = WithdrawCash::find()
            ->where(['user_id'=>$user_id,'status'=>WithdrawCash::STATUS_DOING])
            ->sum('value');
        $money  = $money ? $money : 0;
        return $money;
    }

}