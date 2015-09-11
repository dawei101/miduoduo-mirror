<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\widgets\Alert;
use common\models\District;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);

$city_seo_pinyin = Yii::$app->request->get('city_pinyin')?Yii::$app->request->get('city_pinyin'):Yii::$app->request->get('param_one');
if( $city_seo_pinyin ){
    $city = District::findOne(['seo_pinyin'=>$city_seo_pinyin]);
}

$lastest_seo_pinyin = Yii::$app->session->get('lastest_seo_pinyin');
if( $city_seo_pinyin && ($lastest_seo_pinyin != $city_seo_pinyin) ){
    $lastest_seo_pinyin = $city_seo_pinyin;
    Yii::$app->session->set('lastest_seo_pinyin', $lastest_seo_pinyin);
}
if( $lastest_seo_pinyin ){
    $jz_url = Yii::$app->params["baseurl.frontend"].'/'.$lastest_seo_pinyin.'/p1/';
}else{
    $jz_url = Yii::$app->params["baseurl.frontend"].'/change-city';
}

?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <?= Html::csrfMetaTags() ?>
    <title><?=isset($this->page_title)?$this->page_title:''?><?=isset($this->title)?$this->title:''?> - 米多多兼职</title>
    <meta name="keywords"  content="<?=isset($this->page_keywords)?$this->page_keywords:''?>"/>
    <meta name="description"  content="<?=isset($this->page_description)?$this->page_description:''?>"/>
    <link rel="shortcut icon"  href="<?=Yii::$app->params["baseurl.static.www"]?>/static/img/miduoduo.ico" />
    <link href="<?=Yii::$app->params["baseurl.static.www"]?>/static/css/miduoduo.css" type="text/css" rel="stylesheet" >
    <link href="<?=Yii::$app->params["baseurl.static.www"]?>/static/css/task.css" type="text/css" rel="stylesheet" >
    <?php echo isset($this->blocks['css'])?$this->blocks['css']:''; ?>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>
    <div class="nav-top">
        <div class="nav">
            <div class="qiuzhi-logo">
                <img src="<?=Yii::$app->params["baseurl.static.www"]?>/static/img/qiuzhi-logo.png" width="60" height="60">
                <?php //echo $city->short_name;exit; ?>
                <?php if(isset($city->short_name)){ ?>
                    <span><?=$city->short_name?><a href="<?=Yii::$app->params["baseurl.frontend"]?>/change-city">[切换城市]</a></span>
                <?php } ?>
            </div>
            <ul>
                <li><a href="<?=Yii::$app->params["baseurl.frontend"]?>">首页</a></li>
                <li><a href="<?=$jz_url?>">最新兼职</a></li>
                <li><a href="<?=Yii::$app->params["baseurl.m"]?>">手机版</a></li>
                <li><a href="<?=Yii::$app->params["baseurl.corp"]?>">企业版</a></li>
            </ul>
        </div>
    </div>
    <?= $content ?>
    <footer>
        <ul>
            <li class="contact-us1">
                <h2>联系我们</h2>
                <p>邮箱：<?=Yii::$app->params['supportEmail']?></p>
                <p>电话：<?=Yii::$app->params['supportTel']?></p>
            </li>
            <li class="about-us">
                <h2>关于我们</h2>
                <p><a href="<?=Yii::$app->params['baseurl.frontend']?>/site/about">公司介绍</a></p>
                <p><a href="<?=Yii::$app->params['baseurl.frontend']?>/site/team">团队介绍</a></p>
            </li>
                <li class="xian"></li>
                <li class="attention-us">
                <h2>关注我们</h2>
                <div class="erwei"><img src="<?=Yii::$app->params["baseurl.static.www"]?>/static/img/erwei.jpg" width="70" height="70">
                <div class="er-text">微信关注<br />米多多</div>
                </div>
            </li>
        </ul>
    </footer>
</body>
</html>
<script src="<?=Yii::$app->params["baseurl.static.www"]?>/static/js/jquery.min.js"></script>
<?php echo isset($this->blocks['js'])?$this->blocks['js']:''; ?>
<?php $this->endPage() ?>
