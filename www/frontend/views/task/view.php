<?php

use yii\helpers\Url;

use common\models\District;
use common\models\ServiceType;
use common\Seo;
use yii\widgets\LinkPager;
use common\BaseController;
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
<div class="nav_title"><a href="<?=Yii::$app->params['baseurl.frontend']?>">米多多</a> &gt; <a href="<?=Yii::$app->params['baseurl.frontend']?>/<?=$seo_pinyin?>/p1/">北京兼职</a> &gt; <a href="<?=Yii::$app->params['baseurl.frontend']?>/<?=$seo_pinyin?>/<?=$task->service_type->pinyin?>/">北京<?=$task->service_type->name?></a></div>
<div class="center_c">
  <div class="cnter_left">
    <div class="midd_title">
      <div class="lis_left_11">
        <h2><?= $task->title ?></h2>
        <span class="red_r"><?= floor($task->salary); ?>/<?= $task::$SALARY_UNITS[$task->salary_unit] ?></span><span>|</span><span><?=$task::$CLEARANCE_PERIODS[$task->clearance_period]?></span><span>|</span><span><?=$task->service_type->name?></span>
        <span>
            <?php
            if ($task->city) {
                echo $task->city->name;
            }
            if ($task->district) {
                echo ' - '.$task->district->name;
            } ?>
            <?=$task->address?>
        </span> </div>
      <div class="lis_left_22"><?=isset($task->updated_time)?BaseController::timePast($task->updated_time):BaseController::timePast($task->created_time)?></div>
    </div>
    <div class="midd_yq">
      <div><span>要求：</span>
            <?=$task->gender_requirement ? $task::$GENDER_REQUIREMENT[$task->gender_requirement].' ' : ''?>
            <?=$task->degree_requirement ? $task::$DEGREE_REQUIREMENT[$task->degree_requirement].' ' : ''?>
            <?=$task->height_requirement ? $task::$HEIGHT_REQUIREMENT[$task->height_requirement].' ' : ''?>
            <?=$task->health_certificated ? $task::$HEALTH_CERTIFICATED[$task->health_certificated].' ' : ''?>
            <?php
                if( !$task->gender_requirement && !$task->degree_requirement
                && !$task->height_requirement && !$task->health_certificated){
                    echo '无特殊要求';
                }
            ?>
      </div>
      <div><span>日期：</span>
            <?php if($task->is_longterm){ ?>
            长期兼职
            <?php }else{ ?>
            <?=substr($task->from_date, 5);?>
            至
            <?=substr($task->to_date, 5)?>
            <?php } ?>
      </div>
      <div><span>时间：</span>
            <?php if($task->is_allday){ ?>
             不限工作时间
            <?php }else{ ?>
             <?=substr($task->from_time, 0,5);?>
                至
             <?=substr($task->to_time, 0,5)?>
            <?php } ?>
      </div>
      <div><span>地址：</span><?php if(isset($task->addresses)){foreach($task->addresses as $k => $v){ ?><?=$v->title?><?=$v->address?'，':''?><?=$v->address?>；<?php }} ?></div>
    </div>
    <div class="midd_xq_title">职位描述</div>
    <div class="midd_xq_text">
        <?=$task->detail?>
    </div>
    <div class="midd_xq_title">公司信息</div>
    <div class="midd_xq_text">
      <P><?=$task->company_name?></P>
    </div>
    <div class="midd_xq_title">求职说明</div>
    <div class="midd_xq_text">
      <P>如果您在求职中，遇到企业无理要求支付押金，或者工作内容与实际发布内容不符，请与我们及时联系，米多多会及时处理。</P>
      <p>如果您遇到欺诈，米多多提供兼职呢欺诈赔付，<a href="#">赔付方案</a></p>
    </div>
    <div class="midd_xq_title">报名方式</div>
    <div class="midd_xq_text">
      <div class="tex">微信扫码，立即报名该职位</div>
      <img src="<?=Yii::$app->params["baseurl.static.www"]?>/static/img/erwei.jpg" width="287" height="287"> </div>
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
    <div class="remen_jz"> <a href="#">长期客服</a> <a href="#">长期客服</a><a href="#">长期客服</a><a href="#">长期客服</a><a href="#">长期客服</a><a href="#">长期客服</a><a href="#">长期客服</a><a href="#">长期客服</a><a href="#">长期客服</a><a href="#">长期客服</a><a href="#">长期客服</a><a href="#">长期客服</a><a href="#">长期客服</a><a href="#">长期客服</a><a href="#">长期客服</a><a href="#">长期客服</a><a href="#">长期客服</a><a href="#">长期客服</a><a href="#">长期客服</a><a href="#">长期客服</a><a href="#">长期客服</a><a href="#">长期客服</a><a href="#">长期客服</a><a href="#">长期客服</a> </div>
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