define(function(require,exports){function handle_action(data,responseCallback){var rst={action:"q_before_quit",result:{value:!0}};""!=location.hash?(location.hash="",rst.result.value=!1,responseCallback(rst)):util.cf({title:"注意",message:"确定放弃编辑吗？"},function(data){0==data.result.value&&(rst.result.value=!1),responseCallback(rst)})}require("zepto-ext");var api=require("../widget/api"),util=require("../widget/util"),calendar=require("../widget/calendar");WebViewJavascriptBridge.defaultHandler(handle_action),location.hash="";var tpl=require("../widget/tpl-engine");$("body").append(tpl.parse("main1-tpl",{})),$("body").append(tpl.parse("main2-tpl",{})),calendar.initCalendar(),$(".js-birthday").on("click",function(){$(".calendar-widget, .shade-widget").show(300)}),$(".sex").find("div").on("click",function(){$(this).addClass("sex-act").siblings().removeClass("sex-act")}),$(".sub2-con-val").on("click",function(){$(this).toggleClass("sub2-con-val-act")});var timeName=["morning","afternoon","evening"];$(".dateCol > .time").on("click",function(){var $this=$(this),classStr="time-act",dayIndex=$this.parent().index()+1,timeIndex=$this.index()-1,data={};$this.hasClass(classStr)?($this.removeClass(classStr),data[timeName[timeIndex]]=0):($this.addClass(classStr),data[timeName[timeIndex]]=1),$.put(api.gen("freetime/"+dayIndex),data,function(data){console.log(data)})}),$(".freetime-all").on("click",function(){$(".dateCol > .time").addClass("time-act"),$.post(api.gen("freetime/free-all"),{},function(data){console.log(data)})}),$(".js-sel-service-type").on("click",function(e){$(".sel-job-type").show()}),$(".js-set-address").on("click",function(){var $this=$(this);util.setAddress(function(data){data&&($this.find("input").val(data.address),$.post(api.gen("address"),data,function(data){console.log(data)}))})}),$(".submit-btn").on("click",function(){var data={};$(".js-col").each(function(){data[$(this).attr("name")]=$(this).val()});var $sc=$(".js-special-col");data[$sc.attr("name")]=$sc.find(".sex-act").data("val"),console.log("简历",data),$.post(api.gen("resume"),data,function(data){if(422!=arguments[2].status)util.showTips("提交成功",function(){util.pop()});else{var tipsArr=data,tipsStr="";if(tipsArr.forEach(function(e){tipsStr+=e.message+"\n"}),window.WebViewJavascriptBridge){var opts={action:"b_toast_alert",data:{message:tipsStr,disappear_delay:2e3}};window.WebViewJavascriptBridge.send(opts,null)}else alert(tipsStr)}})}),require("./resume-job-type")});