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
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <?php echo isset($this->blocks['css'])?$this->blocks['css']:''; ?>
</head>
<body>
    <?php $this->beginBody() ?>
    <div class="wrap">
        <div class="container">
        <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
        <p class="pull-left">&copy; 米多多 <?= date('Y') ?></p>
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
</body>
</html>
<?php $this->endPage() ?>
