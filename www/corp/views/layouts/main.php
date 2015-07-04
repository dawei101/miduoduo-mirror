<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use corp\assets\AppAsset;
use corp\widgets\Alert;

/* @var $this \yii\web\View */
/* @var $content string */


AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta http-equiv="pragma" content="no-cache">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link href="/font/iconfont.css" type="text/css" rel="stylesheet">
    <link href="/css/bootstrap.min.css" type="text/css" rel="stylesheet" />
    <link href="/css/miduoduo-qy.css" type="text/css" rel="stylesheet" />
    <script src="/js/jquery.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
</head>
<body>
    <?php $this->beginBody() ?>
    <!--======导航======-->
    <div class="navbar midd-nav midd-2a3141 navbar-default navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="midd-nav-head navbar-left">
          <button type="button" class="navbar-toggle" data-toggle="collapse"
             data-target="#example-navbar-collapse"> <span class="sr-only">切换导航</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
          <a class="navbar-brand" href="#"><img src="img/qiye-logo.png"></a> </div>
        <div class="collapse navbar-collapse" id="example-navbar-collapse">
          <ul class="nav navbar-nav navbar-right">
            <li class="active"><a href="#">我的职位</a></li>
            <li><a href="#">我要发布</a></li>
            <li><a href="#">简历管理</a></li>
            <li><a href="#">消息
                <!--
                <em style="background:#fed732  ; border-radius:20px; padding:0 10px;  color:#fff; z-index:40">1</em>
            -->
                </a></li>
            <li><a href="#">用户中心</a></li>
          </ul>
        </div>
      </div>
    </div>

    <!--main content start-->
    <?= $content ?>
    <!--main content end-->

    <div class="foots">
      <div class="container foot">
        <div class="row">
          <div class="col-sm-12 col-md-4 col-lg-4">
               <h2>联系我们</h2>
               <p>邮箱：pangleimewe@126.com</p>
               <p>电话：400-7890886</p>
          </div>
          <div class="col-sm-12 col-md-4 col-lg-4">
               <h2>关于我们</h2>
               <p><a href="#">公司介绍</a></p>
               <p><a href="#">团队介绍</a></p>
          </div>
          <div class="col-sm-12 col-md-4 col-lg-4">
               <h2>关注我们</h2>
               <div class="erwei"><img src="img/mzhan.png" width="70" height="70"><div class="er-text">扫码进入m站</div></div>
               <div class="erwei"><img src="img/weixin.png" width="70" height="70"><div class="er-text">关注微信公众号</div></div>
          </div>
        </div>
      </div>
    </div>
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
