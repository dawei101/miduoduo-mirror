<?php

use yii\helpers\Url;

use common\models\District;
use common\models\ServiceType;
use common\Seo;
use yii\widgets\LinkPager;
use common\BaseController;

$districts = District::find()->where(['parent_id'=>$city->id])->all();
$service_types = ServiceType::find()->where(['status'=>0])->all();


/********* seo start ***********/
$seocity    = isset($city->name)?$city->name:'';
if( $current_district->id != $city->id ){
    $block      = $current_district->name;
    $page_type  = 'block';
}else{
    $block      = '';
    $page_type  = 'city';
}
$type       = $current_service_type?$current_service_type->name:'';
if( $type ){
    $seocity    = $current_district->name;
    $page_type  = 'type';
}
$clearance_type = '';
$conpany    = '';
$task_title = '';

$seo_code   = Seo::makeSeoCode($seocity,$block,$type,$clearance_type,$conpany,$task_title,$page_type);
/********* seo end ***********/

$this->title = ($current_service_type?$current_service_type->name:'') . '兼职列表';
//$this->page_title = $seo_code['title'];
//$this->page_keywords = $seo_code['keywords'];
//$this->page_description = $seo_code['description'];

//$this->nav_left_link = 'javascript:window.history.back()';
//$this->nav_right_link = $seo_params['city_pinyin'] ? '/'.$seo_params['city_pinyin'].'/' : '/';
//$this->nav_right_title = '首页';
/* @var $this yii\web\View */

//$this->wechat_apis = ['getLocation'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1.0, maximum-scale=1.0" />
<link rel="shortcut icon"  href="img/miduoduo.ico" />
<title>米多多/兼职平台</title>
<link href="/static/css/miduoduo.css" type="text/css" rel="stylesheet" >
<link href="/static/css/task.css" type="text/css" rel="stylesheet" >
</head>
<body>
<div class="nav-top">
  <div class="nav">
    <div class="qiuzhi-logo"><img src="<?=Yii::$app->params["baseurl.static.www"]?>/static/img/qiuzhi-logo.png" width="244" height="80"></div>
    <ul>
      <li><a href="#">首页</a></li>
      <li><a href="#">最新兼职</a></li>
      <li><a href="#">直聘职位</a></li>
      <li><a href="#">企业版</a></li>
    </ul>
  </div>
</div>
<div class="nav_title"><a href="<?=Yii::$app->params['baseurl.frontend']?>">米多多</a> &gt; <a href="<?=Yii::$app->params['baseurl.frontend']?>/<?=$seo_params['city_pinyin']?>/p1/">北京兼职</a></div>
<ul class="nav_sx">
   <li>
   		<div class="nav_sx_left">区域：</div>
        <div class="nav_sx_right">
            <a href="<?=Url::current(['district_pinyin'=>''])?>" class="">全城</a>
            <?php foreach($districts as $district) { ?>
                <a href="<?=Url::current(['district_pinyin'=>$district->seo_pinyin])?>">
                    <?=$district->name?>
                </a>
            <?php } ?>
        </div>
   </li>
   <li>
   		<div class="nav_sx_left">分类：</div>
        <div class="nav_sx_right">
            <a href="<?=Url::current(['type_pinyin'=>''])?>">全部</a>
            <?php foreach($service_types as $st) { ?>
                <a href="<?=Url::current(['type_pinyin'=>$st['pinyin']])?>">
                    <?=$st->name?>
                </a>
            <?php } ?>
        </div>
   </li>
</ul>
<div class="center_c">
<div class="cnter_left">
    <ul class="lis">
        <?php foreach ($tasks as $task){ if(isset($task->id)){ ?>
            <li>
            <a href="/<?=$seo_params['city_pinyin']?>/<?=$task->service_type->pinyin?>/<?=$task->gid?>">
               <div class="lis_left_1">
                  <h2><?=$task->title ?></h2>
                  <span><?=$task->service_type->name?></span>
                  <span>
                    <?php
                    if ($task->city) {
                        echo $task->city->name;
                    }
                    if ($task->district) {
                        echo ' - '.$task->district->name;
                    } ?>
                    <?=$task->address?>
                  </span>
               </div>
               <div class="lis_left_2"><span class="red_r"><?=$task->salary?>元/<?=$task::$SALARY_UNITS[$task->salary_unit]?></span><span><?=$task::$CLEARANCE_PERIODS[$task->clearance_period]?></span></div>
               <div class="lis_left_3"><?=isset($task->updated_time)?BaseController::timePast($task->updated_time):BaseController::timePast($task->created_time)?></div>
             </a>
            </li>
        <?php }} ?>
        <div class="page">
            <?=LinkPager::widget([
                'pagination' => $pages,
                'maxButtonCount'=>4,
                'lastPageLabel'=>'末页', 'nextPageLabel'=>'下一页',
                'prevPageLabel'=>'上一页', 'firstPageLabel'=>'首页'])
                ?>
        </div>
    </ul>
</div>
<div class="cnter_right">
    <div class="right_title">急聘岗位</div>
    <ul class="jipin_list">
        <li><a href="#"><span>200/天</span>去哪网客服</a></li>
        <li><a href="#"><span>200/天</span>去哪网客服</a></li>
        <li><a href="#"><span>200/天</span>去哪网客服</a></li>
        <li><a href="#"><span>200/天</span>去哪网客服</a></li>
        <li><a href="#"><span>200/天</span>去哪网客服</a></li>
    </ul>
    <div class="right_title">扫码快速找兼职</div>
    <div class="erwei_img"><img src="<?=Yii::$app->params["baseurl.static.www"]?>/static/img/erwei.jpg" width="287" height="287"></div>
    <div class="right_title">热门兼职</div>
    <div class="remen_jz">
       <a href="#">长期客服</a> <a href="#">长期客服</a><a href="#">长期客服</a><a href="#">长期客服</a><a href="#">长期客服</a><a href="#">长期客服</a><a href="#">长期客服</a><a href="#">长期客服</a><a href="#">长期客服</a><a href="#">长期客服</a><a href="#">长期客服</a><a href="#">长期客服</a><a href="#">长期客服</a><a href="#">长期客服</a><a href="#">长期客服</a><a href="#">长期客服</a><a href="#">长期客服</a><a href="#">长期客服</a><a href="#">长期客服</a><a href="#">长期客服</a><a href="#">长期客服</a><a href="#">长期客服</a><a href="#">长期客服</a><a href="#">长期客服</a>
    </div>
  </div>
</div>
<div class="zhiwei_tj"> <a href="#">长期客服</a> <a href="#">长期客服</a><a href="#">长期客服</a><a href="#">长期客服</a><a href="#">长期客服</a><a href="#">长期客服</a><a href="#">长期客服</a><a href="#">长期客服</a><a href="#">长期客长期客服服</a><a href="#">长期客服</a><a href="#">长期客服</a><a href="#">长期客服</a><a href="#">长期客服</a><a href="#">长期客服</a><a href="#">长期客长期服</a><a href="#">长期客服</a><a href="#">长期客服</a><a href="#">长期客服</a><a href="#">长期客服</a><a href="#">长期客服</a><a href="#">长期客服</a><a href="#">长期客服长期客服</a><a href="#">长期客服</a> <a href="#">长期客服</a><a href="#">长期客服</a><a href="#">长期客服</a><a href="#">长期客服</a><a href="#">长期客服</a><a href="#">长期客服</a><a href="#">长期客服</a><a href="#">长期客长期客服服</a><a href="#">长期客服</a><a href="#">长期客服</a><a href="#">长期客服</a><a href="#">长期客服</a><a href="#">长期客服</a><a href="#">长期客长期服</a><a href="#">长期客服</a><a href="#">长期客服</a><a href="#">长期客服</a><a href="#">长期客服</a><a href="#">长期客服</a><a href="#">长期客服</a><a href="#">长期客服长期客服</a></div>

<footer>
  <ul>
    <li class="contact-us1">
      <h2>联系我们</h2>
      <p>邮箱：coutact@miduoduo.cn</p>
      <p>电话：010-84991662</p>
    </li>
    <li class="about-us">
      <h2>关于我们</h2>
      <p><a href="#">公司介绍</a></p>
      <p><a href="#">团队介绍</a></p>
    </li>
    <li class="xian"></li>
    <li class="attention-us">
      <h2>关注我们</h2>
      <div class="erwei"><img src="<?=Yii::$app->params["baseurl.static.www"]?>/static/img/fooerwei.jpg" width="70" height="70">
        <div class="er-text">扫码进入m站</div>
      </div>
      <!-- <div class="erwei"><img src="img/fooerwei1.jpg" width="70" height="70"><div class="er-text">关注微信公众号</div></div>--> 
    </li>
  </ul>
</footer>
</body>
</html>