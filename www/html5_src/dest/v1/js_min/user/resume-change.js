define(function(require,exports){function handle_action(data,responseCallback){var rst={action:"q_before_quit",result:{value:!0}};util.cf({title:"注意",message:"确定放弃编辑吗？"},function(data){0==data.result.value&&(rst.result.value=!1),responseCallback(rst)})}require("zepto-ext");var homeID,tpl=require("../widget/tpl-engine"),api=require("../widget/api"),util=require("../widget/util"),calendar=require("../widget/calendar");WebViewJavascriptBridge.defaultHandler(handle_action),$.get(api.gen("resume?expand=service_types,freetimes,home_address,workplace_address"),function(data){console.log(data);var user=data.items[0];$("body").append(tpl.parse("main-tpl",{user:user})),calendar.initCalendar(user.birthdate&&new Date(user.birthdate.replace(/-/g,"/")));var $days=$(".dateTitle"),freeTimes=user.freetimes;freeTimes.forEach(function(e){var $day=$days.eq(e.dayofweek-1),$times=$day.siblings();1==e.morning&&$times.eq(0).addClass("time-act"),1==e.afternoon&&$times.eq(1).addClass("time-act"),1==e.evening&&$times.eq(2).addClass("time-act")}),$(".js-birthday").on("click",function(){$(".calendar-widget, .shade-widget").show(300)}),$(".sex").find("div").on("click",function(){$(this).addClass("sex-act").siblings().removeClass("sex-act")}),$(".sub2-con-val").on("click",function(){$(this).toggleClass("sub2-con-val-act")});var timeName=["morning","afternoon","evening"];$(".dateCol > .time").on("click",function(){var $this=$(this),classStr="time-act",dayIndex=$this.parent().index()+1,timeIndex=$this.index()-1,data={};$this.hasClass(classStr)?($this.removeClass(classStr),data[timeName[timeIndex]]=0):($this.addClass(classStr),data[timeName[timeIndex]]=1),$.put(api.gen("freetime/"+dayIndex),data,function(data){console.log(data)})}),$(".freetime-all").on("click",function(){$(".dateCol > .time").addClass("time-act"),$.post(api.gen("freetime/free-all"),{},function(data){console.log(data)})}),$(".js-sel-service-type").on("click",function(){$(".sel-job-type").show();var typeCodeStr=$(this).find("input").val();if($(this).find("input").val(""),typeCodeStr){var typeCode=typeCodeStr.split(",");typeCode.forEach(function(e){$(".type-item[data-code='"+e+"']").addClass("type-act")})}}),$(".js-set-address").on("click",function(){var $this=$(this);util.setAddress($(this).find("input").val(),function(data){data&&($this.find("input").val(data.address),$.post(api.gen("address"),data,function(data){homeID=data.id}))})}),require("./resume-job-type"),$(".submit-btn").on("click",function(){var data={};$(".js-col").each(function(){data[$(this).attr("name")]=$(this).val()});var $sc=$(".js-special-col");data[$sc.attr("name")]=$sc.find(".sex-act").data("val"),data.phonenum=miduoduo.user.phone,data.home=homeID,console.log("简历",data),$.put(api.gen("resume/"+miduoduo.user.id),data,function(data){util.showTips("修改成功！",function(){miduoduo.os.mddApp?util.pop(!0):alert("兼容app外浏览器，待定")})})})})});