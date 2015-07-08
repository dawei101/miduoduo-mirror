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
                            <dt class="pitch-on"><i class="iconfont">&#xe609;</i>我要发布</dt>
                        </dl>
                        <dl>
                            <dt class="default-title"><i class="iconfont">&#xe612;</i>职位管理</dt>
                            <dd class="default-lis"><a href="#">显示中</a></dd>
                            <dd class="default-lis"><a href="#">审核中</a></dd>
                            <dd class="default-lis"><a href="#">审核未通过</a></dd>
                        </dl>
                        <dl>
                            <dt class="default-title"><i class="iconfont">&#xe60c;</i>简历管理</dt>
                            <dd class="default-lis"><a href="#">未查看</a></dd>
                            <dd class="default-lis"><a href="#">已查看</a></dd>
                            <dd class="default-lis"><a href="#">全部</a></dd>
                        </dl>
                        <dl>
                            <dt class="default-title"><i class="iconfont">&#xe60b;</i>用户中心</dt>
                            <dd class="default-lis"><a href="#">我的资料</a></dd>
                            <dd class="default-lis"><a href="#">我的账号</a></dd>
                        </dl>
                    </div>
                </div>
                <div class="col-sm-12 col-md-10 col-lg-10 padding-0 ">
                    <div class="right-center">
                        <div class="conter-title">发布兼职职位</div>
                        <?php $form = ActiveForm::begin();?>
                        <ul class="tianxie-box">
                            <li>
                                <div class="pull-left title-left text-center"><em>*</em>兼职标题</div>
                                <div class="pull-left right-box">
                                    <input name="title" type="text" placeholder="请简述职位标题，字数控制在20字内">
                                </div>
                            </li>
                            <li>
                                <div class="pull-left title-left text-center"><em>*</em>兼职类别</div>
                                <div class="pull-left right-box zhiweileibie">
                                    <div class="nice-select" name="nice-select">
                                        <input type="text" value=" ===选择职位类别===" ><i class="iconfont">&#xe60d;</i>
                                        <ul>
                                            <li data-value="1">礼仪</li>
                                            <li data-value="2">广东省</li>
                                            <li data-value="3">湖南省</li>
                                            <li data-value="4">四川省</li>
                                            <li data-value="1">湖北省</li>
                                            <li data-value="2">广东省</li>
                                            <li data-value="3">湖南省</li>
                                            <li data-value="4">四川省</li>
                                        </ul>
                                        <input type="hidden" name="service_type_id" value="1"/>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="pull-left title-left text-center"><em>*</em>工作时间</div>
                                <div class="pull-left right-box div">
                                    <div class="riqi">
                                        <input name="from_date" type="text" style="width: 200px" name="reservation" class="reservation" placeholder="选择您的起始日期" value="2016-06-10"/>
                                        <div class="nice-select times" name="nice-select">
                                            <input name="from_time" type="text" value="13:00" ><i class="iconfont">&#xe60d;</i>
                                            <ul>
                                                <li data-value="1">00:00</li>
                                                <li data-value="2">00:30</li>
                                                <li data-value="3">01:00</li>
                                                <li data-value="4">01:30</li>
                                                <li data-value="1">02:00</li>
                                                <li data-value="2">02:30</li>
                                                <li data-value="3">03:00</li>
                                                <li data-value="4">03:30</li>
                                            </ul>
                                        </div>
                                        <span class="pull-left">至</span>
                                        <div class="nice-select times" name="nice-select">
                                            <input name="to_time" type="text" value="13:00" >
                                            <i class="iconfont">&#xe60d;</i>
                                            <ul>
                                                <li data-value="1">00:00</li>
                                                <li data-value="2">00:30</li>
                                                <li data-value="3">01:00</li>
                                                <li data-value="4">01:30</li>
                                                <li data-value="1">02:00</li>
                                                <li data-value="2">02:30</li>
                                                <li data-value="3">03:00</li>
                                                <li data-value="4">03:30</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="pull-left title-left text-center"><em>*</em>截止日期</div>
                                <div class="pull-left right-box">
                                    <input name="to_date" type="text" readonly style="width: 200px" name="birthday" id="birthday" value="2016-06-12" />
                                </div>
                            </li>
                            <li>
                                <div class="pull-left title-left text-center"><em>*</em>工作地址</div>
                                <div class="pull-left right-box">
                                    <div class="nice-select quyu" name="nice-select">
                                        <input type="text" value="北京" >
                                        <i class="iconfont">&#xe60d;</i>
                                        <ul>
                                            <li data-value="1">朝阳区</li>
                                            <li data-value="2">海淀区</li>
                                            <li data-value="3">崇文区</li>
                                            <li data-value="4">昌平区</li>
                                            <li data-value="1">宣武区</li>
                                            <li data-value="2">通州</li>
                                            <li data-value="3">平谷区</li>
                                            <li data-value="4">怀柔区</li>
                                        </ul>
                                    </div>
                                    <input type="text" class="dz-input" placeholder="详细位位置，多地址用“；”隔开，如：地址A；地址B">
                                    <button class="queren">确认</button>
                                    <!--
                                    <div class="dl-xs">
                                        <p><i class="iconfont">&#xe60e;</i>米多多会根据您填写的地址把信息推送给不同位置的兼职者，帮您精准定位！请直接在左侧修改内容标红地址或在地图上选择地址（拖动可修改）</p>
                                        <ul class="pull-left dl-left">
                                            <li contenteditable="true">金融街21号中国联通大厦</li>
                                            <li contenteditable="true">金融街21号中国联通大厦</li>
                                            <li contenteditable="true">金融街21号中国联通大厦</li>
                                            <li contenteditable="true">金融街21号中国联通大厦</li>
                                            <li contenteditable="true">金融街21号中国联通大厦</li>
                                            <li contenteditable="true">金融街21号中国联通大厦</li>
                                        </ul>
                                        <div class="pull-right dl-pic"><img src="img/ditu.jpg" width="400" height="300"></div>
                                    </div>
                                -->
                                </div>
                            </li>
                            <li>
                                <div class="pull-left title-left text-center"><em>*</em>工作内容</div>
                                <div class="pull-left right-box">
                                    <!--
                                    <div id="editor" class="edit">
                                        <p>工作时间：</p>
                                        <p>工作薪酬：</p>
                                        <p>工作要求：</p>
                                    </div>
                                -->
                                    <textarea name="detail">
                                        工作时间：aaa
                                        工作薪酬：bbb
                                        工作要求：ccc
                                    </textarea>
                                </div>
                            </li>
                            <li>
                                <div class="pull-left title-left text-center"><em>*</em>人员要求</div>
                                <div class="pull-left right-box input-z">
                                    <div class="nice-select pull-left ma-right"><input name="need_quantity" type="text" class="pull-left" placeholder="人数"></div>
                                    <div class="nice-select pull-left ma-right" name="nice-select">
                                        <input name="gender_requirement" type="text" class="text-center" value="性别" >
                                        <i class="iconfont">&#xe60d;</i>
                                        <ul>
                                            <li>男女不限</li>
                                            <li>男</li>
                                            <li>女</li>
                                        </ul>
                                    </div>
                                    <div class="nice-select pull-left ma-right" name="nice-select">
                                        <input type="text" class="text-center" value="身高" >
                                        <i class="iconfont">&#xe60d;</i>
                                        <ul>
                                            <li>150cm以下</li>
                                            <li>150cm</li>
                                            <li>155cm</li>
                                        </ul>
                                    </div>
                                    <span class="add-xs">+添加</span>
                                </div>
                                <div class="add-ons">
                                    <div class="nice-select pull-left add-ons-input" name="nice-select">
                                        <input type="text" value="形象" >
                                        <i class="iconfont">&#xe60d;</i>
                                        <ul>
                                            <li>好</li>
                                            <li>一般</li>
                                            <li>非常好</li>
                                        </ul>
                                    </div>
                                    <div class="nice-select pull-left add-ons-input" name="nice-select">
                                        <input type="text" value="沟通能力" >
                                        <i class="iconfont">&#xe60d;</i>
                                        <ul>
                                            <li>强</li>
                                            <li>一般</li>
                                        </ul>
                                    </div>
                                    <div class="nice-select pull-left add-ons-input" name="nice-select">
                                        <input type="text" value="健康证" >
                                        <i class="iconfont">&#xe60d;</i>
                                        <ul>
                                            <li>有</li>
                                            <li>无</li>
                                        </ul>
                                    </div>
                                    <div class="nice-select pull-left add-ons-input" name="nice-select">
                                        <input type="text" value="学历" >
                                        <i class="iconfont">&#xe60d;</i>
                                        <ul>
                                            <li>本科以上</li>
                                            <li>本科</li>
                                            <li>大专</li>
                                            <li>高中</li>
                                            <li>无</li>
                                        </ul>
                                    </div>
                                    <div class="nice-select pull-left add-ons-input" name="nice-select">
                                        <input type="text" value="体重" >
                                        <i class="iconfont">&#xe60d;</i>
                                        <ul>
                                            <li>60kg以下</li>
                                            <li>60-65kg</li>
                                            <li>65-70kg</li>
                                            <li>70-75kg</li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="pull-left title-left text-center"><em>*</em>薪酬</div>
                                <div class="pull-left right-box input-z">
                                    <div class="nice-select pull-left ma-right"><input name="salary" type="text" class="pull-left" placeholder="数量，如100"></div>
                                    <div class="nice-select pull-left ma-right" name="nice-select">
                                        <input type="text" class="text-center" value="金额单位" />
                                        <input name="salary_unit" type="hidden" value="1" />
                                        <i class="iconfont">&#xe60d;</i>
                                        <ul>
                                            <li>元/天</li>
                                            <li>元/月</li>
                                        </ul>
                                    </div>
                                    <div class="nice-select pull-left ma-right ma-right" name="nice-select">
                                        <input type="text" class="text-center" value="结算方式" />
                                        <input name="salary_note" type="hidden" value="1" />
                                        <i class="iconfont">&#xe60d;</i>
                                        <ul>
                                            <li>周结</li>
                                            <li>月结</li>
                                            <li>日结</li>
                                        </ul>
                                    </div>
                                    <div class="pull-left yuji">预计有25名应聘者</div>
                                </div>
                            </li>
                            <li>
                                <div class="pull-left title-left text-center">报名方式</div>
                                <div class="pull-left right-box baoming">
                                    <div class="bm-text">请至少选择一种报名方式</div>
                                    <div class="fixde bm-fs"><span><input name="phone_contact" type="checkbox" value="">电话报名</span><input name="contact" type="text" placeholder="联系人"><input name="contact_phonenum" type="text" placeholder="联系电话"></div>
                                    <div  class="fixde bm-fs"><span><input name="sms_contact" type="checkbox" value="">短信报名</span><input name="" type="text" placeholder="18600098028"><input type="text" placeholder="姓名+电话+性别+应聘岗位+米多多"></div>
                                </div>
                            </li>
                        </ul>
                        <div class="agree"><input name="" type="checkbox" value="">我已阅读并同意<a href="#">米多多发布兼职协议</a></div>
                        <button class="fabu-bt">发布职位</button>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- InstanceEndEditable -->
