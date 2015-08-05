<?php
/**
 */

namespace console\controllers;

use Yii;
use yii\console\Controller;
use common\payment\WechatPayment;

/**
 */

class PaymentController extends Controller
{
    /**
     * @var string controller default action ID.
     */
    public $defaultAction = 'list';


    public function actionTestPay($openid){
        $payment = new WechatPayment;
        echo $payment->payout($openid, 1, $openid . time(), '测试送钱');
        echo "\n";
    }
}
