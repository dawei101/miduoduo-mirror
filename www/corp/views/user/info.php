<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
$this->title = '米多多兼职平台';
?>

<!-- InstanceBeginEditable name="EditRegion3" -->
<div class="body-box">
<div class="midd-kong"></div>
<div class="container">
  <div class="row">
    <div class="fabu-box padding-0">
      <div class="col-sm-12 col-md-2 col-lg-2 padding-0" style="background:#f00">
        <div class="qiye-left">
          <dl>
            <dt class="default-title"><i class="iconfont">&#xe609;</i><a href="/task/publish">我要发布</a></dt>
          </dl>
          <dl>
            <dt  class="default-title" class=""><i class="iconfont">&#xe612;</i>职位管理</dt>
            <dd class="default-lis"><a href="/task">全部</a></dd>
            <dd class="default-lis"><a href="/task?status=0">显示中</a></dd>
            <dd class="default-lis"><a href="/task?status=30">审核中</a></dd>
            <dd class="default-lis"><a href="/task?status=40">审核未通过</a></dd>
          </dl>
          <dl  class="default-title">
            <dt class="default-title"><i class="iconfont">&#xe60c;</i>简历管理</dt>
            <dd class="default-lis"><a href="/resume">全部</a></dd>
            <dd class="default-lis"><a href="/resume?status=10">已接受</a></dd>
            <dd class="default-lis"><a href="/resume?status=0">未处理</a></dd>
          </dl>
          <dl class="pitch-current">
            <dt class="default-title"><i class="iconfont">&#xe60b;</i>用户中心</dt>
            <dd class="current"><a href="/user/info">我的资料</a></dd>
            <dd class="default-lis"><a href="/user/account">修改密码</a></dd>
            <dd class="default-lis"><a href="/user/personal-cert">个人认证</a></dd>
            <dd class="default-lis"><a href="/user/corp-cert">企业认证</a></dd>
          </dl>
        </div>
      </div>
      <div class="col-sm-12 col-md-10 col-lg-10 padding-0 ">
        <div class="right-center">
            <div class="conter-title">我的资料</div>
        <?php $form = ActiveForm::begin();?>
          <ul class="tianxie-box" style="border:none">
              <li>
                <div class="pull-left title-left text-center">公司名称</div>
                <div class="pull-left right-box">
                  <input name="name" type="text" placeholder="输入公司名称" value="<?=$company->name?>">
                </div>
              </li>
              <li>
                  <div class="pull-left title-left text-center">所属行业</div>
                  <div class="pull-left right-box zhiweileibie">
                    <div class="nice-select" name="nice-select">
                      <input name="service" type="text" placeholder="选择行业" value="<?=$company->service?>" >
                      <i class="iconfont">&#xe60d;</i>
                      <ul>
                        <?php foreach($services as $service) {?>
                        <li><?=$service->name?></li>
                        <?php }?>
                      </ul>
                    </div>
                  </div>
                </li>
                <li>
                  <div class="pull-left title-left text-center">企业性质</div>
                  <div class="pull-left right-box zhiweileibie">
                    <div class="nice-select" name="nice-select">
                      <input name="corp_type" type="text" placeholder="选择公司性质" value="<?=$company->corp_type?>">
                      <i class="iconfont">&#xe60d;</i>
                      <ul>
                        <li data-value="1">国企</li>
                        <li data-value="2">私企</li>
                        <li data-value="3">股份制</li>
                      </ul>
                    </div>
                  </div>
                </li>
                <li>
                  <div class="pull-left title-left text-center">企业规模</div>
                  <div class="pull-left right-box zhiweileibie">
                    <div class="nice-select" name="nice-select">
                      <input name="corp_size" type="text" placeholder="选择公司规模" value="<?=$company->corp_size?>">
                      <i class="iconfont">&#xe60d;</i>
                      <ul>
                        <li>0-20人</li>
                        <li>20-100人</li>
                        <li>100人以上</li>
                      </ul>
                    </div>
                  </div>
                </li>
                <li>
                  <div class="pull-left title-left text-center">公司简介</div>
                  <div class="pull-left right-box zhiweileibie">
                    <textarea name="intro" id="textarea" class="text-area" onblur="if(this.innerHTML==''){this.innerHTML='请填写您的公司简介';this.style.color='#999'}" style="COLOR: #999" onfocus="if(this.innerHTML=='请填写您的公司简介'){this.innerHTML='';this.style.color='#999'}"><?=$company->intro?></textarea>
                  </div>
                </li>
                <button class="queding-bt" onclick="$(this).closest('form').submit();">确定</button>
           </ul>
        <?php ActiveForm::end(); ?>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- InstanceEndEditable -->

<?php
$this->registerJsFile('/js/miduoduo.js');
?>
