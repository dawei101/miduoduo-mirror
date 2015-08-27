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
<a href="#" class="pic_f cd-popup-trigger">
    <p>
        <?php if(isset($weichat_user->resume->name)){ ?>
            <?=$weichat_user->resume->name?>分享的红包。
        <?php } ?>
    长按二维码微信关注可领取现金红包，亲试有效，赶紧去领吧！</p>
    <img src="<?=Yii::$app->params['weichat']['url']['erweima_show'].$erweima_ticket?>">
    <p class="fenxiang-btn">立即分享</p>
</a>
<!--=======以藏的弹出层======-->
<div class="cd-popup" role="alert">
<img src="<?=Yii::$app->params['baseurl.static.m']?>/static/img/red-packet/fex.png" </div>
<script type="text/javascript" src="<?=Yii::$app->params['baseurl.static.m']?>/static/js/jquery.min.js"></script> 
<script src="<?=Yii::$app->params['baseurl.static.m']?>/static/js/red-packet.js"></script>

</body>
</html>
