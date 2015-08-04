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
                <div class="col-sm-2 padding-0">
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

                <div class="col-sm-10 padding-0 ">
                    <div class="right-center">
                        <div class="conter-title">发布兼职职位<span style="font-size:12px;padding-left:20px;"><?= $user_task_promission['msg'] ?></span></div>
                        <?php if($user_task_promission['result']==false){ ?>
                            <div class="tishi-cs">
                                您今天的发布次数已经用完，请明天再来哟 ~ 
                                <?php if($user_task_promission['exam_result'] < 32){ ?>
                                    立即认证可增加发布条数，<a href="/user/corp-cert">去认证</a>
                                <?php } ?>
                            </div>
                        <?php } ?>
                        <?php $form = ActiveForm::begin();?>
                        <ul class="tianxie-box">
                            <li>
                                <div class="pull-left title-left text-center"><em>*</em>兼职标题</div>
                                <div class="pull-left right-box">
                                    <input name="title" type="text" placeholder="请简述职位标题，字数控制在20字内" value="<?=$task->title?>">
                                    <p class="cuowu title-error">内容不能为空!</p>
                                </div>
                            </li>
                          <li>
                                <div class="pull-left title-left text-center"><em>*</em>兼职类别</div>
                                <div class="pull-left right-box zhiweileibie">
                                    <div class="nice-select tl" name="nice-select">
                                        <input type="text" readonly placeholder=" ===选择职位类别===" value="<?=$task->service_type_id?$task->getService_type()->one()->name:''?>">
                                        <ul>
                                        	<?php foreach($services as $service) {?>
                        					<li><?=$service->name?></li>
                        					<?php }?>
                                        </ul>
                                        <input type="hidden" name="service_type_id" value="<?=$task->service_type_id?$task->getService_type()->one()->name:''?>"/>
                                        <p class="cuowu service_type_id-error">内容不能为空!</p>
                                    </div>
                                </div>
                            </li>
                            <li>
                              <div class="pull-left title-left text-center"><em>*</em>工作时间</div>
                              <div class="pull-left right-box div">
                                <div class="riqi">
                                  <input type="text" readonly style="width: 330px" class="reservation" value="<?=$task->from_date&&$task->to_date?$task->from_date.' - '.$task->to_date:date('Y-m-d').' - '.date('Y-m-d')?>" placeholder="选择您的工作起始日期"/>
                                  <label><input name="is_longterm" type="checkbox" class="changqi" <?=$task&&$task->is_longterm?'checked':''?>>长期招聘</label>
                                  <input name="from_date" type="hidden" value="<?=$task->from_date?$task->from_date:date('Y-m-d')?>"/>
                                  <input name="to_date" type="hidden" value="<?=$task->to_date?$task->to_date:date('Y-m-d')?>"/>
                              </div>
                              <p class="cuowu from_time-error">内容不能为空!</p>
                              <div class="time-xz">
                                  <div class="nice-select times" name="nice-select">
                                    <input name="from_time" type="text" placeholder="上班时间" readonly value="<?=$task->from_time?$task->from_time:''?>" >
                                    <ul>
                                        <li>06:00</li>
                                        <li>07:00</li>
                                        <li>08:00</li>
                                        <li>09:00</li>
                                        <li>10:00</li>
                                        <li>11:00</li>
                                        <li>12:00</li>
                                        <li>13:00</li>
                                        <li>14:00</li>
                                        <li>15:00</li>
                                        <li>16:00</li>
                                        <li>17:00</li>
                                        <li>18:00</li>
                                        <li>19:00</li>
                                        <li>20:00</li>
                                        <li>21:00</li>
                                        <li>22:00</li>
                                        <li>23:00</li>
                                    </ul>
                                  </div>
                                  <span class="pull-left">至</span>
                                  <div class="nice-select times" name="nice-select">
                                    <input name="to_time" type="text" placeholder="下班时间" readonly value="<?=$task->to_time?$task->to_time:''?>" >
                                    <ul>
                                        <li>06:00</li>
                                        <li>07:00</li>
                                        <li>08:00</li>
                                        <li>09:00</li>
                                        <li>10:00</li>
                                        <li>11:00</li>
                                        <li>12:00</li>
                                        <li>13:00</li>
                                        <li>14:00</li>
                                        <li>15:00</li>
                                        <li>16:00</li>
                                        <li>17:00</li>
                                        <li>18:00</li>
                                        <li>19:00</li>
                                        <li>20:00</li>
                                        <li>21:00</li>
                                        <li>22:00</li>
                                        <li>23:00</li>
                                    </ul>
                                  </div>
                              </div>
                              <p class="cuowu to_time-error">内容不能为空!</p>
                            </li>
                            <!--
                            <li>
                                <div class="pull-left title-left text-center"><em>*</em>报名截止日期</div>
                                <div class="pull-left right-box">
                                    <div class="riqi">
                                        <input name="end_date" type="text" readonly style="width: 330px" name="birthday" id="birthday" value="<?=$task->to_date?$task->to_date:date('Y-m-d')?>" /></div>
                                        <p class="cuowu">内容不能为空!</p>
                                    </div>
                                </li>
                                -->
                                <li>
                                    <div class="pull-left title-left text-center"><em>*</em>工作地址</div>
                                    <div class="pull-left right-box">
<!--
                                    <div class="nice-select quyu" name="nice-select">
                                        <input id="address_count" type="text" placeholder="地址" value="一个">
                                        
                                        <ul>
                                            <li>不限</li>
                                            <li>一个</li>
                                            <li>多个</li>
                                        </ul>
                                    </div> 
                                        <div class="nice-select quyu" name="nice-select">
                                            <input type="text" readonly value="北京" >
                                        </div> -->
                                        <span class="tianj">+添加</span>
                                        <input type="text" placeholder="输入回车可选择位置信息 用于添加坐标 提升投递量" name="address" id="jquery-tagbox-text1" class="add-v"/>
                                        <input type="hidden" name="address_list"/>
                                        <ul class="dizhi" id="search-result" style="display:none"></ul>
                                        <p class="cuowu address_error">内容不能为空!</p>
                                    </div>
                                    <div class="zhi" id="selected-address">
                                    <?php foreach($address as $item){?>
                                        <div class="p-box" id="<?=$item->id?>"><span>&times;</span><div class="dz-v"><?=$item->title?></div></div>
                                    <?php }?>
                                    </div>
                                </li>
                                <li>
                                    <div class="pull-left title-left text-center"><em>*</em>工作内容</div>
                                    <div class="pull-left right-box">
                                        <div id="editor" class="edit">
                                            <?php if($task->detail) {
                                                echo $task->detail;
                                            }else{?>
                                            <p>工作时间：</p>
                                            <p>工作薪酬：</p>
                                            <p>工作要求：</p>
                                            <?php  }?>
                                        </div>
                                        <input type="hidden" name="detail" value="$task->detail"/>
                                        <p class="cuowu detail-error">内容不能为空!</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="pull-left title-left text-center"><em>*</em>人员要求</div>
                                    <div class="pull-left right-box input-z">
                                        <div class="nice-select pull-left ma-right wsj">
                                            <input name="need_quantity" type="text" class="pull-left" placeholder="人数" value="<?=$task?$task->need_quantity:''?>">
                                        </div>
                                        <div class="nice-select pull-left ma-right" name="nice-select">
                                            <input name="gender_requirement" readonly type="text" placeholder="性别" value="<?=$task->gender_requirement!=false?TASK::$GENDER_REQUIREMENT[$task->gender_requirement]:'男女不限'?>">
                                            
                                            <ul>
                                                <li>男女不限</li>
                                                <li>男</li>
                                                <li>女</li>
                                            </ul>
                                        </div>
                                        <div class="nice-select pull-left ma-right" name="nice-select">
                                            <input name="height_requirement" type="text" readonly placeholder="身高" value="<?=$task->height_requirement!=false?TASK::$HEIGHT_REQUIREMENT[$task->height_requirement]:'身高无要求'?>">
                                            
                                            <ul>
                                                <li>身高无要求</li>
                                                <li>155cm以上</li>
                                                <li>165cm以上</li>
                                                <li>170cm以上</li>
                                                <li>175cm以上</li>
                                            </ul>
                                        </div>
                                        <span class="add-xs">+其他要求</span>
                                    </div>
                                    <div class="add-ons">
                                        <div class="nice-select pull-left add-ons-input" name="nice-select">
                                            <input name="face_requirement" type="text" readonly placeholder="形象" value="<?=$task->face_requirement!=false?TASK::$FACE_REQUIREMENT[$task->face_requirement]:'形象无要求'?>">
                                            
                                            <ul>
                                                <li>形象无要求</li>
                                                <li>形象好</li>
                                                <li>形象非常好</li>
                                            </ul>
                                        </div>
                                        <div class="nice-select pull-left add-ons-input" name="nice-select">
                                            <input name="talk_requirement" type="text" readonly placeholder="沟通能力" value="<?=$task->talk_requirement!=false?TASK::$TALK_REQUIREMENT[$task->talk_requirement]:'沟通能力无要求'?>">
                                            
                                            <ul>
                                                <li>沟通能力无要求</li>
                                                <li>沟通能力强</li>
                                            </ul>
                                        </div>
                                        <div class="nice-select pull-left add-ons-input" name="nice-select">
                                            <input name="health_certificated" type="text" readonly placeholder="健康证" value="<?=$task->health_certificated!=false?TASK::$HEALTH_CERTIFICATED[$task->health_certificated]:'健康证无要求'?>">
                                            
                                            <ul>
                                                <li>有健康证</li>
                                                <li>健康证无要求</li>
                                            </ul>
                                        </div>
                                        <div class="nice-select pull-left add-ons-input" name="nice-select">
                                            <input name="degree_requirement" type="text" readonly placeholder="学历" value="<?=$task->degree_requirement!=false?TASK::$DEGREE_REQUIREMENT[$task->degree_requirement]:'学历无要求'?>">
                                            
                                            <ul>
                                                <li>本科以上</li>
                                                <li>本科</li>
                                                <li>大专</li>
                                                <li>高中</li>
                                                <li>学历无要求</li>
                                            </ul>
                                        </div>
                                        <div class="nice-select pull-left add-ons-input" name="nice-select">
                                            <input name="weight_requirement" type="text" readonly placeholder="体重" value="<?=$task->weight_requirement!=false?TASK::$WEIGHT_REQUIREMENT[$task->weight_requirement]:'体重无要求'?>">
                                            
                                            <ul>
                                                <li>体重无要求</li>
                                                <li>60kg以下</li>
                                                <li>60-65kg</li>
                                                <li>65-70kg</li>
                                                <li>70-75kg</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <p class="cuowu need_quantity-error ql">内容不能为空!</p>
                                </li>
                                <li>
                                    <div class="pull-left title-left text-center"><em>*</em>薪酬</div>
                                    <div class="pull-left right-box input-z">
                                        <div class="nice-select pull-left ma-right wsj">
                                            <input name="salary" type="text" class="pull-left" placeholder="数量，如100" value="<?=$task->salary?sprintf("%.1f",$task->salary):''?>">
                                        </div>
                                        <div class="nice-select pull-left ma-right" name="nice-select">
                                            <input name="salary_unit" type="text" readonly placeholder="薪酬单位" value="<?=strlen($task->salary_unit)>0?'元/'.TASK::$SALARY_UNITS[$task->salary_unit]:''?>">
                                            
                                            <ul>
                                                <li>元/小时</li>
                                                <li>元/天</li>
                                                <li>元/周</li>
                                                <li>元/月</li>
                                                <li>元/次</li>
                                            </ul>
                                        </div>
                                        <div class="nice-select pull-left ma-right ma-right" name="nice-select">
                                            <input type="text" name="clearance_period" readonly placeholder="结算方式" value="<?=$task->clearance_period!=false?TASK::$CLEARANCE_PERIODS[$task->clearance_period]:''?>">
                                            
                                            <ul>
                                                <li>月结</li>
                                                <li>周结</li>
                                                <li>日结</li>
                                                <li>完工结</li>
                                            </ul>
                                        </div>
                                        <!--<div class="pull-left yuji">预计有25名应聘者</div>-->
                                        <p class="cuowu salary-error">内容不能为空!</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="pull-left title-left text-center">报名方式</div>
                                    <div class="pull-left right-box baoming">
                                        <div class="bm-text">请至少选择一种报名方式</div>
                                        <div class="fixde bm-fs"><span><input name="phone_contact" type="checkbox" checked>电话报名</span>
                                            <input name="contact" type="text" placeholder="联系人" value="<?=$task->contact?$task->contact:$company->contact_name?>">
                                            <input name="contact_phonenum" type="text" placeholder="联系电话" value="<?=$task->contact_phonenum?$task->contact_phonenum:$company->contact_phone?>">
                                        </div>
                                        <div  class="fixde bm-fs"><span><input name="sms_contact" type="checkbox" checked>短信报名</span>
                                            <input name="sms_phonenum" type="text" placeholder="请填写手机号码" value="<?=$task->sms_phonenum ? $task->sms_phonenum : Yii::$app->user->identity->username?>">
                                        </div>
                                        <p class="cuowu enroll-error">内容不能为空!</p>
                                    </div>
                                </li>
                            </ul>
                            <div class="agree">
                                <input name="protocol" type="checkbox" checked>我已阅读并同意<a href="/static/release_agreement.html">米多多发布兼职协议</a>
                                <p class="cuowu protocol-error">内容不能为空!</p>
                            </div>
                            <?php if($user_task_promission['result']==false){ ?>
                                <button class="fabu-bt" disabled="disabled">今天发布次数已经用完</button>
                            <?php }else{ ?>
                                <button class="fabu-bt">发布职位</button>
                            <?php } ?>
                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<div id="map" style="display:none"></div>
	<script src="<?=Yii::$app->params["baseurl.static.corp"]?>/static/js/miduoduo.js"></script>
	<script src="<?=Yii::$app->params["baseurl.static.corp"]?>/static/js/data/moment.js"></script>
	<script src="<?=Yii::$app->params["baseurl.static.corp"]?>/static/js/data/daterangepicker.js"></script>

	<script src="<?=Yii::$app->params["baseurl.static.corp"]?>/static/js/fuwenben/bootstrap-wysiwyg.js"></script>
	<script src="<?=Yii::$app->params["baseurl.static.corp"]?>/static/js/fuwenben/external/jquery.hotkeys.js"></script>
	<script src="<?=Yii::$app->params["baseurl.static.corp"]?>/static/js/jquery.tagbox.js"></script>
    <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=GB9AZpYwfhnkMysnlzwSdRqq"> </script>
<!-- InstanceEndEditable -->
<?php
$this->registerJsFile(Yii::$app->params["baseurl.static.corp"] . '/static/js/publish.js');
?>

    <!--
    <?php print_r($address);?>
-->
