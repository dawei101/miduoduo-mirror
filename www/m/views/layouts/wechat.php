<?php

$tstamp = time();
$nonce = strval(rand(100000, 999999));

?>
<div style="display:none;">
    <img src="/static/img/weichat_icon.jpg" /> 
</div>

<script>
wx.config({
    debug: true,
    appId: <?=Yii:$app->params['weichat']['appid']?>
    timestamp: <?=time()?>, // 必填，生成签名的时间戳
    nonceStr: <?=?>, // 必填，生成签名的随机串
    signature: '',// 必填，签名，见附录1
    jsApiList: [
       <?php foreach($apis as $api) {
            echo '"' . $api . '" ,',
        }
        ?>
    ] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
});

</script>
