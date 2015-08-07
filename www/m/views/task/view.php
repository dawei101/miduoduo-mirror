<?php
use common\models\TaskCollection;
use common\Seo;

/********* seo start ***********/
$city       = isset($task->city->name)?$task->city->name:'';
$block      = '';
$type       = '';
$clearance_type = '';
$conpany    = $task->company_name;
$task_title = $task->title;
$page_type  = 'detail';

$need_quantity  = $task->need_quantity;
$address        = '';
if(isset($task->addresses)){
    foreach($task->addresses as $k => $v){ 
        $address    .= $v->title.','.$v->address.';';
    }
}
$salary         = floor($task->salary);
$detail         = $task->detail;

$seo_code   = Seo::makeSeoCode($city,$block,$type,$clearance_type,$conpany,$task_title,$page_type,$need_quantity,$address,$salary,$detail);
/********* seo end ***********/

$this->title = '兼职详情';
$this->page_title = $seo_code['title'];
$this->page_keywords = $seo_code['keywords'];
$this->page_description = $seo_code['description'];

$this->nav_left_link = 'javascript:window.history.back()';
$this->nav_right_link = '/';
$this->nav_right_title = '首页';
?>
<?php $this->beginBlock('css') ?>
<link href="<?=Yii::$app->params["baseurl.static.m"]?>/static/css/tankuang.css" rel="stylesheet"> 
<style>
   .gs-bb{border-bottom:#f3f3f3 solid 1px; border-bottom: 1px solid #f3f3f3;margin-bottom: 0.6em;padding-bottom: 0.6em;}
    .detail ul, .detail ol, .detail dl {
        padding-left: 2em;
    }
</style>
<?php $this->endBlock('css')?>
<!--======详情======-->
<div class="midd-xiangqing">
  <div class="list-title">
    <h2><?= $task->title ?></h2>
  </div>
  <div class="list-tag">
    <span class="tag-im">￥<?= floor($task->salary); ?>/<?= $task::$SALARY_UNITS[$task->salary_unit] ?></span>
    <?php if ($task->labels_str){
     foreach($task->labels as $label) {?>
        <span><?=$label?></span>
    <?php }}?>
    <span style="border:0px;">
    |&nbsp;&nbsp;<?=$task->clearance_period_label?>
    &nbsp;&nbsp;|&nbsp;&nbsp;已报名：<?=$task->got_quantity?>/<?=$task->need_quantity?>人
    </span>
  </div>
</div>
<div class="list-subsection">
    <dl>
       <dt>工作周期</dt>
       <dd>
           <?php if($task->is_longterm){ ?>
             长期兼职
           <?php }else{ ?>
             <?=substr($task->from_date, 5);?>
                至
             <?=substr($task->to_date, 5)?>
           <?php } ?>
       </dd>
    </dl>
    <dl>
       <dt>工作时间</dt>
       <dd>
           <?php if($task->is_allday){ ?>
             不限工作时间
           <?php }else{ ?>
             <?=substr($task->from_time, 0,5);?>
                至
             <?=substr($task->to_time, 0,5)?>
           <?php } ?>
       </dd>
    </dl>
    <dl>
      <dt>工作地点</dt>
      <dd><?php if(isset($task->addresses)){foreach($task->addresses as $k => $v){ ?><?=$v->title?><?=$v->address?'，':''?><?=$v->address?>；<?php }} ?></dd>
    </dl>
</div>
<div class="list-subsection">
    <dl>
       <dt>工作内容</dt>
       <dd class="detail"><?=$task->detail?></dd>
    </dl>
</div>
<div class="list-subsection">
    <dl>
       <dt>公司信息</dt>
       <dd><?=$task->company_name?></dd>
       <dd>
            <div>
                <p>联系人：<?=$task->contact?></p>
                <p>联系电话:<?=$task->contact_phonenum?></p>
           </div>
      </dd>
    </dl>
</div>
<div class="mdd-bottom-nav">
    <?php if (!$collected){ ?>
     <a id="collect" class="midd-l bottom-box ">
        <i class="iconfont">&#xe60d;</i><span style="display:block">收藏</span>
     </a>
    <?php } else { ?>
     <a class="midd-l bottom-box pitch-on">
        <i class="iconfont">&#xe607;</i><span style="display:block">已收藏</span>
     </a>
    <?php } ?>


      <?php if(!$complainted){ ?>
        <a href="/complaint/create?id=<?=$task->id?>" class="midd-l bottom-box">
        <i class="iconfont">&#xe60f;</i><span style="display:block">举报</span>
     </a>
    <?php } else { ?>
        <a  class="midd-l bottom-box">
        <i class="iconfont">&#xe60f;</i><span style="display:block">已举报</span>
        </a>
    <?php } ?>
        <?php if ($app && $app->status==0){ ?>
            <div style="background: #a5abb2;" class="midd-l bottom-bnt bottom-bnt-bm"><?=$app->status_label?></div>
        <?php } else if ($app && $app->status==10) { ?>
            <div style="background: #ff7b5d;" class="midd-l bottom-bnt bottom-bnt-bm"><?=$app->status_label?></div>
        <?php }
        if(!$app) { ?>
            <?php if ($task->status > 0){ ?>
                <div style="background: #a5abb2;" class="midd-l bottom-bnt bottom-bnt-bm"><?=$task->status_label?></div>
            <?php }else{ ?>
                <?php if($task->is_overflow){ ?>
                    <div style="background: #a5abb2;" class="midd-l bottom-bnt bottom-bnt-bm"><?=$task->is_overflow_label?></div>
                <?php }else{ ?>
                  <?php if(Yii::$app->user->id){?>
                    <div id="apply" class="midd-l bottom-bnt bottom-bnt-bm cd-popup-trigger">我要报名</div>
                    <?php }else{?>
                    <div class="midd-l bottom-bnt bottom-bnt-bm cd-popup-trigger">我要报名</div><?php }?>
                <?php } ?>
            <?php } ?>
        <?php } ?>   
</div>

<!--=======以藏的弹出层======-->
<div class="cd-popup" role="alert">
<input type="hidden" value="<?= $resume ?>" id="getResume">
  <div class="cd-popup-container">
    <p><?= (Yii::$app->user->isGuest) ? '你好，报名兼职职位需要登录米多多！':'你好，报名兼职职位需要填写简历！' ?></p>
    <ul class="cd-buttons">
    <?php if(Yii::$app->user->isGuest) { ?> 
        <li><a onclick="GB.signup(location.href);">立即注册</a></li>
        <li><a onclick="GB.login(location.href);">现在登录</a></li>

    <?php }else{ ?>
        <li><a href="/resume/edit">去填简历</a></li>
        <li><a href="">取消</a></li>
     <?php }?>
      
    </ul>
    <a href="#" class="cd-popup-close img-replace">关闭</a>
  </div> 
</div>
<div style="height:90px"></div>

<?php $this->beginBlock('js') ?>
<script>
$(function(){
    $("#collect").bind(GB.click_event, function(){
        $.ajax({
            url: '/task-collection/create',
            method: 'post',
            data: {
                'task_id': <?=$task->id?>
            }
        }).done(function(data){
            var d = $.parseJSON(data);
            if (d['success']){
                $("#collect").addClass('pitch-on');
                $("#collect").find('i').html('&#xe607');
                $("#collect").find('span').html('已收藏');
            }
            console.info(data);
        }).fail(function(jqXHR, textStatus, errorThrown) {
            if (jqXHR.status=302){
                GB.login(location.href);
            }
        });;
    });
    $("#apply").bind(GB.click_event, function(){
        $.ajax({
            url: '/task-applicant/create',
            method: 'post',
            data: {
                'task_id': <?=$task->id?>
            }
        }).done(function(data){
            var d = $.parseJSON(data);
            if (d['success']){
                location.reload();
            }
            console.info(data);
        }).fail(function(jqXHR, textStatus, errorThrown) {
            if (jqXHR.status==302){
                GB.login(location.href);
            }
        });;
    });
});
</script>
<script src="<?=Yii::$app->params["baseurl.static.m"]?>/static/js/tankuang.js"> </script>

<?php $this->endBlock('js') ?>
