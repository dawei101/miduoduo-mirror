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
    <link href="/css/dashboard.css" rel="stylesheet">
    <?php echo isset($this->blocks['css'])?$this->blocks['css']:''; ?>
</head>
<body>
    <?php $this->beginBody() ?>
    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => '宠爱有家',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
            $menuItems = [
                ['label' => '首页', 'url' => ['/site/index']],
            ];
            if (Yii::$app->user->isGuest) {
                $menuItems[] = ['label' => '登陆', 'url' => ['/site/login']];
            } else {
                $menuItems[] = [
                    'label' => '退出(' . Yii::$app->user->identity->username . ')',
                    'url' => ['/site/logout'],
                    'linkOptions' => ['data-method' => 'post']
                ];
            }
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => $menuItems,
            ]);
            NavBar::end();
        ?>

        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3 col-md-2 sidebar">
                  <ul class="nav nav-sidebar" id="sidebar">
                    <li><a href="/">Overview <span class="sr-only">(current)</span></a></li>
                    <li><a href="/user">账号管理</a></li>

                    <li><a href="/resume">人才库</a></li>
                    <li><a href="/task">任务订单</a></li>
                    <li><a href="/service-type">任务类型</a></li>
                    <li><a href="/offline-order">线下订单</a></li>
                    <li><a href="#">订单委派</a></li>
                  </ul>
                </div>
                <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                <?= $content ?>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="container-fluid">
        <p class="pull-left">&copy; 宠爱有家<?= date('Y') ?></p>
        <p class="pull-right">Powered by David</p>
        </div>
    </footer>
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
</body>
</html>
<?php $this->endPage() ?>
