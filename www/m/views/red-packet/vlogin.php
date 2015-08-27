<?php
use yii\helpers\Html;
use common\Utils;
use common\WeichatBase;
use m\assets\BootstrapAsset;
use m\assets\WechatAsset;
use yii\bootstrap\ButtonGroup;
use yii\bootstrap\ActiveForm;

/* @var $this \yii\web\View */
/* @var $content string */

BootstrapAsset::register($this);

if (Utils::isInWechat()){
    WechatAsset::register($this);
}

?>
<!--
<div class="site-login">
    <div style='padding: 40px 0 10px 10px;color: #999;' > <?=$this->title?> </div>
        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
        <div class="form-list">
            <?= $form->field($model, 'phonenum')->label('手机号')
              ->input('tel', $options = ['data-id'=>'phonenum'] ) ?>
            <div class="form-group">
                <label>验证码</label>
                <div class="yzm">
                    <button id="svcode" type="button" class="btn btn-default form-yzm">获取验证码</button>
                    <input type="text" id="<?= Html::getInputId($model, 'code') ?>"
                      class="form-control" name="<?= Html::getInputName($model, 'code')?>">
                </div>
                <p class="help-block help-block-error"><?=$model->getFirstError('code')?></p>
            </div>
        </div>
    </div>
    <p class="block-btn">
        <?= Html::submitButton('下一步', ['class' => 'btn btn-primary btn-lg btn-block', 'name' => 'login-button']) ?>
    </p>
    <?php ActiveForm::end(); ?>
    <p class="text-right" style="padding-right: 15px; ">
        <a href="/user/vlogin">找回密码</a>
        &nbsp; &nbsp; &nbsp; &nbsp;
        <a href="/user/vlogin">手机验证码登录</a>
    </p>
</div>
-->

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no">
<meta http-equiv="pragma" content="no-cache">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta http-equiv="pragma" content="no-cache">
<meta content="black" name="apple-mobile-web-app-status-bar-style">
<title>米多多送现金红包</title>
<link href="<?=Yii::$app->params['baseurl.static.m']?>/static/css/red-packet.css" type="text/css" rel="stylesheet">
</head>

<body>
<div class="midd_top"><img src="<?=Yii::$app->params['baseurl.static.m']?>/static/img/red-packet/midd_top.jpg"></div>
<div class="midd_main"> <img src="<?=Yii::$app->params['baseurl.static.m']?>/static/img/red-packet/hongbao.png" >
  <div class="title_hb"><img src="<?=Yii::$app->params['baseurl.static.m']?>/static/img/red-packet/xianjian.png" ></div>
  <div class="title_qb"><img src="<?=Yii::$app->params['baseurl.static.m']?>/static/img/red-packet/qianb.png" ></div>
  <div class="input_k">
  <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
     <?= $form->field($model, 'phonenum')->label(false)
              ->input('tel', $options = ['data-id'=>'phonenum' ,'class'=>"input_z", 'placeholder'=>"请输入您的电话号码"] ) ?>
     <div class="yz">
        <input type="text" id="<?= Html::getInputId($model, 'code') ?>"
            class="input_z" name="<?= Html::getInputName($model, 'code')?>">
        <button class="bott" id="svcode">获取验证码</button>
     </div>
     <?= Html::submitButton('立即领取', ['class' => 'botton_l', 'name' => 'login-button']) ?>
   <?php ActiveForm::end(); ?>
     <div class="ts">分享好友，每注册成功一个，则返现<b>2</b>元，多返多送！</div>
  </div>
</div>
<div class="bot_box"><img src="<?=Yii::$app->params['baseurl.static.m']?>/static/img/red-packet/bot_img.jpg"></div>
<div id="tab">
  <div class="ta_l"><span></span></div><div class="ta_r"><span></span></div>
  <ul class="tab_menu">
    <li  style="text-align:center; width:100%">活动规则</li>
  </ul>
  <div class="tab_box">
    <div>
      <p>1、活动时间：20150830-20151230</p>
      <p>2、满10元以上可提现</p>
      <p>3、活动时间：20150830-20151230</p>
      <p>4、活动时间：20150830-20151230</p>
    </div>
   </div>
</div>
<div id="tab">
  <div class="ta_l"><span></span></div><div class="ta_r"><span></span></div>
  <ul class="tab_menu">
    <li style="text-align:center; width:100%">红包榜</li>
  </ul>
  <div class="tab_box">
    <div>
      <dl>
        <dd>第一名</dd>
        <dd>王小明</dd>
        <dd>2000元</dd>
      </dl>
      <dl>
        <dd>第一名</dd>
        <dd>王小明</dd>
        <dd>2000元</dd>
      </dl>
      <dl>
        <dd>第一名</dd>
        <dd>王小明</dd>
        <dd>2000元</dd>
      </dl>
      <dl>
        <dd>第一名</dd>
        <dd>王小明</dd>
        <dd>2000元</dd>
      </dl>
      <dl>
        <dd>第一名</dd>
        <dd>王小明</dd>
        <dd>2000元</dd>
      </dl>
      <dl>
        <dd>第一名</dd>
        <dd>王小明</dd>
        <dd>2000元</dd>
      </dl>
    </div>
   </div>
</div>

<?php $this->beginBlock('js') ?>
<script>
    $(function(){
        var flag=false;
        var vbtn = $("#svcode");
        var pipt = $('input[data-id="phonenum"]');
        var fp = pipt.closest('.form-group');
        var help=fp.find('.help-block');
        var wait=60;
        function time(o) {
            help.html('请您留意短信或来电');
            if (wait == 0) { 
                o.removeClass('form-yzm-c').removeAttr("disabled");
                o.html("获取验证码");
                wait = 60;
            } else {
                o.html(wait + "秒后重试");
                wait--;
                setTimeout(function() { time(o); }, 1000);
            }
        }

        vbtn.bind(GB.click_event, function(){
            if (flag) {
                return false;
            }
            flag = true;
            setTimeout(function(){ flag = false; }, 100);
            $.ajax({url: "/user/vcode",
                'method': 'POST',
                'data': {'phonenum': pipt.val(), 't': $.now()}})
            .done(function(text){
                data =$.parseJSON(text);
                if (data['result']){
                    vbtn.addClass('form-yzm-c').attr("disabled","disabled");
                    time(vbtn);
                } else {
                    fp.addClass('has-error');
                    help.html(data['msg']);
                }
            }).fail(function(){
                fp.addClass('has-error');
                help.html("网络出现问题，请重试.");
            });
        });
    });
</script>
<?php $this->endBlock('js') ?>

</body>
</html>

