<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use m\assets\AppAsset;
use m\widgets\Alert;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no">
    <meta http-equiv="pragma" content="no-cache">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta http-equiv="pragma" content="no-cache">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">

    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <?php echo $this ->blocks['js'];?>
    <?php echo isset($this->blocks['css'])?$this->blocks['css']:''; ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="container">
    <nav class="navbar-fixed-top top-nav" role="navigation">
        <div class="nav-head text-center">
         <?php if ($this->nav_left_link){ ?>
             <a style="height: 50px; line-height: 50px; min-width:60px;" class="text-left pull-left" href="<?=$this->nav_left_link?>">
                <span class="glyphicon glyphicon-chevron-left"> </span>
                <?=$this->nav_left_title?>
            </a>
         <?php } else {?>
            <a style="height: 50px; line-height: 50px; min-width:60px;" class="text-left pull-left"> </a>
         <?php }?>
         <span><?=$this->title?></span>
         <?php if ($this->nav_right_link){ ?>
             <a style="height: 50px; line-height: 50px; min-width:60px;" class="text-right pull-right" href="<?=$this->nav_right_link?>">
                <?=$this->nav_right_title?></a>
         <?php } else {?>
            <a style="height: 50px; line-height: 50px; min-width:60px;" class="text-right pull-right">&nbsp;</a>
         <?php }?>
    </nav>
    <nav class="top-nav"></nav>
    <?= $content ?>
</div>
<?php $this->endBody() ?>



<script>
    GB={};
    GB.is_mobile = (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent));
    GB.click_event = GB.is_mobile?'touchstart':'click';
    $(function() {
        FastClick.attach(document.body);
    });
</script>
<?php echo isset($this->blocks['js'])?$this->blocks['js']:''; ?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
  ga('create', 'UA-64201170-1', 'auto');
  ga('send', 'pageview');
</script>
<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "//hm.baidu.com/hm.js?71fce0b5ae66cac6b8ba9fc072998791";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>
</body>
</html>
<?php $this->endPage() ?>
