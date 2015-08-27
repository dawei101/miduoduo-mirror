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
  <div class="title_hb"><img src="<?=Yii::$app->params['baseurl.static.m']?>/static/img/red-packet/my_hb.png"></div>
  <div class="jin_e"><?=$invited_all*2?>元</div>
  <div class="text_b"> <img src="<?=Yii::$app->params['baseurl.static.m']?>/static/img/red-packet/hb_sm.png"> <a href="<?=Yii::$app->params['baseurl.m']?>/red-packet?id=<?=$user_id?>" class="fenx cd-popup-trigger">分享给好友去赚红包</a> <a href="<?=Yii::$app->params['baseurl.wechat']?>/view/pay/cash-account.html" class="tix">去提现</a> </div>
</div>
<div class="bot_box"><img src="<?=Yii::$app->params['baseurl.static.m']?>/static/img/red-packet/bot_img.jpg"></div>
<div id="tab">
  <div class="ta_l"><span></span></div><div class="ta_r"><span></span></div>
  <ul class="tab_menu">
    <li class="selected">邀请记录</li>
    <li>活动规则</li>
  </ul>
  <div class="tab_box">
    <div>
      <h2>共计<?=$invited_all?>人，可提现<?=$invited_all*2?>元</h2>
      <?php if( $inviteds ){ ?>
        <ul>
            <?php foreach($inviteds as $invited){ ?>
                <li>
                    <span>
                        <?=isset($invited->created_time)?str_ireplace(' ','日 ',str_ireplace('-','月',substr($invited->created_time,5,11))):'未注册'?></li>
                    </span>
                    <?=isset($invited->username)?(substr($invited->username,0,3).'****'.substr($invited->username,-4)):'未注册'?></li>
            <?php } ?>
        </ul>
        <a href="/red-packet/my-records">查看更多<br />
        <img src="<?=Yii::$app->params['baseurl.static.m']?>/static/img/red-packet/more.png" width="29" height="21"></a> </div>
      <?php }else{ ?>
        <a href="<?=Yii::$app->params['baseurl.m']?>/red-packet?id=<?=$user_id?>" style="border:0px;">您还木有收入哦，快快行动吧！</a>
      <?php } ?>
    <div class="hide">
      <p>1、活动时间：2015-08-30 至 2015-12-30</p>
      <p>2、满10元以上可提现</p>
      <p>3、活动时间：20150830-20151230</p>
      <p>4、活动时间：20150830-20151230</p>
    </div>
  </div>
</div>
<!--=======以藏的弹出层======-->
<div class="cd-popup" role="alert">
<img src="<?=Yii::$app->params['baseurl.static.m']?>/static/img/red-packet/fex.png" </div>
<script type="text/javascript" src="<?=Yii::$app->params['baseurl.static.m']?>/static/js/jquery.min.js"></script> 
<script type="text/javascript">
$(document).ready(function(){
	var $tab_li = $('#tab ul li');
	$tab_li.click(function(){
		$(this).addClass('selected').siblings().removeClass('selected');
		var index = $tab_li.index(this);
		$('div.tab_box > div').eq(index).show().siblings().hide();
	});	
});
</script>
</body>
</html>
