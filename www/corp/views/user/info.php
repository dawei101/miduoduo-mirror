<!-- InstanceBeginEditable name="EditRegion3" -->
<div class="body-box">
<div class="midd-kong"></div>
<div class="container">
  <div class="row">
    <div class="fabu-box padding-0">
      <div class="col-sm-12 col-md-2 col-lg-2 padding-0" style="background:#f00">
        <div class="qiye-left">
          <dl>
            <dt class="default-title"><i class="iconfont">&#xe609;</i>我要发布</dt>
          </dl>
          <dl>
            <dt  class="default-title" class=""><i class="iconfont">&#xe612;</i>职位管理</dt>
            <dd class="default-lis"><a href="#">全部</a></dd>
            <dd class="default-lis"><a href="#">显示中</a></dd>
            <dd class="default-lis"><a href="#">审核中</a></dd>
            <dd class="default-lis"><a href="#">审核未通过</a></dd>
          </dl>
          <dl >
            <dt class="default-title"><i class="iconfont">&#xe60c;</i>简历管理</dt>
            <dd class="default-lis"><a href="#">全部</a></dd>
            <dd class="default-lis"><a href="#">未查看</a></dd>
            <dd class="default-lis"><a href="#">已查看</a></dd>
            <dd class="default-lis"><a href="#">全部</a></dd>
          </dl>
          <dl class="pitch-current">
            <dt class="default-title"><i class="iconfont">&#xe60b;</i>用户中心</dt>
            <dd class="current"><a href="#">我的资料</a></dd>
            <dd class="default-lis"><a href="#">我的账号</a></dd>
            <dd class="default-lis"><a href="#">个人认证</a></dd>
            <dd class="default-lis"><a href="#">企业认证</a></dd>
          </dl>
        </div>
      </div>
      <div class="col-sm-12 col-md-10 col-lg-10 padding-0 ">
        <div class="right-center">
        <form>
          <ul class="tianxie-box" style="border:none">
              <li>
                <div class="pull-left title-left text-center">公司名称</div>
                <div class="pull-left right-box">
                  <input type="text" placeholder="输入公司名称">
                </div>
              </li>
              <li>
                  <div class="pull-left title-left text-center">所属行业</div>
                  <div class="pull-left right-box zhiweileibie">
                    <div class="nice-select" name="nice-select">
                      <input type="text" value="选择行业" >
                      <i class="iconfont">&#xe60d;</i>
                      <ul>
                        <li>礼仪</li>
                        <li>广东省</li>
                        <li>湖南省</li>
                        <li>四川省</li>
                        <li>湖北省</li>
                        <li>广东省</li>
                        <li>湖南省</li>
                        <li>四川省</li>
                      </ul>
                    </div>
                  </div>
                </li>
                <li>
                  <div class="pull-left title-left text-center">企业性质</div>
                  <div class="pull-left right-box zhiweileibie">
                    <div class="nice-select" name="nice-select">
                      <input type="text" value="选择公司性质" >
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
                      <input type="text" value="选择公司规模" >
                      <i class="iconfont">&#xe60d;</i>
                      <ul>
                        <li>礼仪</li>
                        <li>广东省</li>
                        <li>湖南省</li>
                        <li>四川省</li>
                      </ul>
                    </div>
                  </div>
                </li>
                <li>
                  <div class="pull-left title-left text-center">公司简介</div>
                  <div class="pull-left right-box zhiweileibie">
                    <textarea id="textarea" class="text-area" onblur="if(this.innerHTML==''){this.innerHTML='请填写您的公司简介';this.style.color='#999'}" style="COLOR: #999" onfocus="if(this.innerHTML=='请填写您的公司简介'){this.innerHTML='';this.style.color='#999'}">请填写您的公司简介</textarea>
                  </div>
                </li>
                <button class="queding-bt">确定</button>
           </ul>
        </form>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- InstanceEndEditable -->

<?php
$this->registerJsFile('/js/miduoduo.js');
?>
