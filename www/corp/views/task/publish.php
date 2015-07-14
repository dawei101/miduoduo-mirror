<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Task;

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
                            <dt class="default-title" class=""><i class="iconfont">&#xe612;</i>职位管理</dt>
                            <dd class="default-lis"><a href="/task">全部</a></dd>
                            <dd class="default-lis"><a href="/task?status=0">显示中</a></dd>
                            <dd class="default-lis"><a href="/task?status=30">审核中</a></dd>
                            <dd class="default-lis"><a href="/task?status=40">审核未通过</a></dd>
                        </dl>
                        <dl  class="default-title">
                            <dt class="default-title"><i class="iconfont">&#xe60c;</i>简历管理</dt>
                            <dd class="default-lis"><a href="/resume">全部</a></dd>
                            <dd class="default-lis"><a href="/resume?read=0">未查看</a></dd>
                            <dd class="default-lis"><a href="/resume?read=1">已查看</a></dd>
                        </dl>
                        <dl>
                            <dt class="default-title"><i class="iconfont">&#xe60b;</i>用户中心</dt>
                            <dd class="default-lis"><a href="/user/info">我的资料</a></dd>
                            <dd class="default-lis"><a href="/user/account">我的账号</a></dd>
                            <dd class="default-lis"><a href="/user/personal-cert">个人认证</a></dd>
                            <dd class="default-lis"><a href="/user/corp-cert">企业认证</a></dd>
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
                                    <input name="title" type="text" placeholder="请简述职位标题，字数控制在20字内" value="<?=$task->title?>">
                                    <p class="cuowu">内容不能为空!</p>
                                </div>
                            </li>
                            <li>
                                <div class="pull-left title-left text-center"><em>*</em>兼职类别</div>
                                <div class="pull-left right-box zhiweileibie">
                                    <div class="nice-select" name="nice-select">
                                        <input type="text" placeholder=" ===选择职位类别===" value="<?=$task->service_type_id?$task->getService_type()->one()->name:''?>"><i class="iconfont">&#xe60d;</i>
                                        <ul>
                                        	<?php foreach($services as $service) {?>
                        					<li><?=$service->name?></li>
                        					<?php }?>
                                        </ul>
                                        <input type="hidden" name="service_type_id" value="<?=$task->service_type_id?$task->getService_type()->one()->name:''?>"/>
                                        <p class="cuowu">内容不能为空!</p>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="pull-left title-left text-center"><em>*</em>工作时间</div>
                                <div class="pull-left right-box div">
                                    <div class="riqi">
                                        <input name="from_date" type="text" readonly style="width: 200px" name="reservation" class="reservation" value="<?=$task?$task->from_date:'2015-08-01'?>" />
                                        <div class="nice-select times" name="nice-select">
                                            <input name="from_time" type="text" value="<?=$task?$task->from_time:'13:00'?>" ><i class="iconfont">&#xe60d;</i>
                                            <ul>
                                                <li>00:00</li>
                                                <li>00:30</li>
                                                <li>01:00</li>
                                                <li>01:30</li>
                                                <li>02:00</li>
                                                <li>02:30</li>
                                                <li>03:00</li>
                                                <li>03:30</li>
                                            </ul>
                                        </div>
                                        <span class="pull-left">至</span>
                                        <div class="nice-select times" name="nice-select">
                                            <input name="to_time" type="text" value="<?=$task?$task->to_time:'13:00'?>" ><i class="iconfont">&#xe60d;</i>
                                            <ul>
                                                <li>00:00</li>
                                                <li>00:30</li>
                                                <li>01:00</li>
                                                <li>01:30</li>
                                                <li>02:00</li>
                                                <li>02:30</li>
                                                <li>03:00</li>
                                                <li>03:30</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <p class="cuowu">内容不能为空!</p>
                                </div>
                            </li>
                            <li>
                                <div class="pull-left title-left text-center"><em>*</em>截止日期</div>
                                <div class="pull-left right-box">
                                    <div class="riqi">
                                        <input name="to_date" type="text" readonly style="width: 200px" name="birthday" id="birthday" value="<?=$task?$task->to_date:'2015-09-01'?>" /></div>
                                        <p class="cuowu">内容不能为空!</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="pull-left title-left text-center"><em>*</em>工作地址</div>
                                    <div class="pull-left right-box">
                                        <div class="nice-select quyu" name="nice-select">
                                            <input type="text" value="北京" ><i class="iconfont">&#xe60d;</i>
                                            <ul>
                                                <li>朝阳区</li>
                                                <li>海淀区</li>
                                                <li>崇文区</li>
                                                <li>昌平区</li>
                                                <li>宣武区</li>
                                                <li>通州</li>
                                                <li>平谷区</li>
                                                <li>怀柔区</li>
                                            </ul>
                                        </div>
                                        <div class="nice-select quyu" name="nice-select">
                                            <input name="city" type="text" value="北京" >
                                            <i class="iconfont">&#xe60d;</i>
                                            <ul>
                                                <li>不限</li>
                                                <li>一个</li>
                                                <li>多个</li>
                                            </ul>
                                        </div>
                                        <input type="text" id="jquery-tagbox-text" />
                                        <p class="cuowu">内容不能为空!</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="pull-left title-left text-center"><em>*</em>工作内容</div>
                                    <div class="pull-left right-box">
                                        <div id="editor" class="edit">
                                            <?php if($task) {
                                                echo $task->detail;
                                            }else{?>
                                            <p>工作时间：</p>
                                            <p>工作薪酬：</p>
                                            <p>工作要求：</p>
                                            <?php  }?>
                                        </div>
                                        <input type="hidden" name="detail" value="$task->detail"/>
                                        <p class="cuowu">内容不能为空!</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="pull-left title-left text-center"><em>*</em>人员要求</div>
                                    <div class="pull-left right-box input-z">
                                        <div class="nice-select pull-left ma-right">
                                            <input name="need_quantity" type="text" class="pull-left" placeholder="人数" value="<?=$task->need_quantity?>">
                                        </div>
                                        <div class="nice-select pull-left ma-right" name="nice-select">
                                            <input name="gender_requirement" type="text" class="text-center" placeholder="性别" value="<?=$task->gender_requirement?TASK::$GENDER_REQUIREMENT[$task->gender_requirement]:''?>">
                                            <i class="iconfont">&#xe60d;</i>
                                            <ul>
                                                <li>男女不限</li>
                                                <li>男</li>
                                                <li>女</li>
                                            </ul>
                                        </div>
                                        <div class="nice-select pull-left ma-right" name="nice-select">
                                            <input name="height_requirement" type="text" class="text-center" placeholder="身高" value="<?=$task->height_requirement?TASK::$HEIGHT_REQUIREMENT[$task->height_requirement]:''?>">
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
                                            <input name="face_requirement" type="text" placeholder="形象" value="<?=$task->face_requirement?TASK::$FACE_REQUIREMENT[$task->face_requirement]:''?>">
                                            <i class="iconfont">&#xe60d;</i>
                                            <ul>
                                                <li>好</li>
                                                <li>一般</li>
                                                <li>非常好</li>
                                            </ul>
                                        </div>
                                        <div class="nice-select pull-left add-ons-input" name="nice-select">
                                            <input name="talk_requirement" type="text" placeholder="沟通能力" value="<?=$task->talk_requirement?TASK::$TALK_REQUIREMENT[$task->talk_requirement]:''?>">
                                            <i class="iconfont">&#xe60d;</i>
                                            <ul>
                                                <li>强</li>
                                                <li>一般</li>
                                            </ul>
                                        </div>
                                        <div class="nice-select pull-left add-ons-input" name="nice-select">
                                            <input name="health_certificated" type="text" placeholder="健康证" value="<?=$task->health_certificated?TASK::$HEALTH_CERTIFICATED[$task->health_certificated]:''?>">
                                            <i class="iconfont">&#xe60d;</i>
                                            <ul>
                                                <li>有</li>
                                                <li>无</li>
                                            </ul>
                                        </div>
                                        <div class="nice-select pull-left add-ons-input" name="nice-select">
                                            <input name="degree_requirement" type="text" placeholder="学历" value="<?=$task->degree_requirement?TASK::$DEGREE_REQUIREMENT[$task->degree_requirement]:''?>">
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
                                            <input name="weight_requirement" type="text" placeholder="体重" value="<?=$task->weight_requirement?TASK::$WEIGHT_REQUIREMENT[$task->weight_requirement]:''?>">
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
                                        <div class="nice-select pull-left ma-right">
                                            <input name="salary" type="text" class="pull-left" placeholder="数量，如100" value="<?=$task->salary?>">
                                        </div>
                                        <div class="nice-select pull-left ma-right" name="nice-select">
                                            <input name="salary_unit" type="text" class="text-center" placeholder="金额单位" value="<?=$task->salary_unit?TASK::$SALARY_UNITS[$task->salary_unit]:''?>">
                                            <i class="iconfont">&#xe60d;</i>
                                            <ul>
                                                <li>元/天</li>
                                                <li>元/月</li>
                                            </ul>
                                        </div>
                                        <div class="nice-select pull-left ma-right ma-right" name="nice-select">
                                            <input type="text" class="text-center" name="clearance_period" placeholder="结算方式" value="<?=$task->clearance_period?TASK::$CLEARANCE_PERIODS[$task->clearance_period]:''?>">
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
	<script src="/js/miduoduo.js"></script>
	<script src="/js/data/moment.js"></script>
	<script src="/js/data/daterangepicker.js"></script>

	<script src="/js/fuwenben/bootstrap-wysiwyg.js"></script>
	<script src="/js/fuwenben/external/jquery.hotkeys.js"></script>
	<script src="/js/jquery.tagbox.js"></script>
<!-- InstanceEndEditable -->
<?php
$this->registerJsFile('/js/publish.js');
?>
