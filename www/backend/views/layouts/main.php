<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <?php echo isset($this->blocks['css'])?$this->blocks['css']:''; ?>
</head>
<body>
    <?php $this->beginBody() ?>
    <div id="wrapper">
        <!-- Sidebar -->
        <div id="sidebar-wrapper">
              <ul class="sidebar-nav">
                <li class="sidebar-brand">
                    <a href="/"> 米多多 </a>
                </li>
                <li><a href="/user">账号管理</a></li>
                <li><a href="/resume">人才库</a></li>
                <li><a href="/company">企业库</a></li>
                <li><a href="/service-type">任务类型</a></li>
                <li><a href="/task">任务</a></li>
                <li><a href="/task-applicant">任务报名单</a></li>
                <li><a href="/complaint">投诉列表</a></li>
                
                <li>&nbsp;</li>
                <li><a href="/weichat-push-set-pushset">微信推送-附近</a></li>
                <li><a href="/weichat-push-set-template-push-list">微信推送-附近-模板</a></li>
                <li><a href="/weichat-push-quality-task">微信推送-优单</a></li>
                <li><a href="/weichat-user-info">微信推送-绑定用户</a></li>
                <li><a href="/weichat-erweima">微信二维码</a></li>
                <li>&nbsp;</li>
                <li><a href="/config-recommend">后台配置-推荐兼职</a></li>
                <li>&nbsp;</li>
                <li><a href="/app-release-version">应用发布管理</a></li>
                <li>
                    <a href="/support/report-bug">
                    <span class="glyphicon glyphicon-flag" style="color:red;"></span> 提交bug
                    </a>
                </li>
<?php if (Yii::$app->user->isGuest) { ?>
                <li><a href="/site/login">登陆</a></li>
<?php } else { ?>
                <li><a href="/site/logout" data-method="post">退出</a></li>
<?php } ?>


        </div>
        <div id="page-content-wrapper">
            <div id="sidebar-toggle" class="text-right">
                <span class="glyphicon glyphicon-list"></span>
            </div>
            <div class="container-fluid">
<?= $content ?>
            </div>
        </div>
    </div>
    <?php $this->endBody() ?>
    <script>
        GB={};
        GB.is_mobile = (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent));
        GB.click_event = GB.is_mobile?'touchstart':'click';
    </script>
    <?php echo isset($this->blocks['js'])?$this->blocks['js']:''; ?>
    <script>
        $(function(){
            var uri=location.pathname;
            console.info(uri);
            $.each($('#sidebar a'), function(i, v){
                var a =$(v);
                var muri = a.attr('href');
                if (uri==muri){
                    a.closest('li').addClass('active');
                }
            });
        });

    </script>
        <script>
    $("#sidebar-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>
</body>
</html>
<?php $this->endPage() ?>
