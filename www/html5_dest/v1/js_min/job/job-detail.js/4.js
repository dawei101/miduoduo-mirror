define(function(require,exports){function buildControlBar(){function showBarWhenReqOver(){reqOver--,0==reqOver&&$(".part5").show()}if(miduoduo.user.id){var reqOver=2;$.get(api.gen("task-applicant/"+taskID+"?expand=task"),function(data){if(data.task){var $obj=$(".control-btn");$obj.removeClass("js-unapply"),0==data.status?$obj.text("等待企业确认").css("background","#a5abb2"):10==data.status&&$obj.text("报名成功").css("background","#ff7b5d")}else;showBarWhenReqOver()},"json"),$.get(api.gen("task-collection/"+taskID),function(data){console.log(data),data instanceof Array&&0==data.length||$(".store").addClass("store-act"),showBarWhenReqOver()},"json")}else $(".part5").show();$(".js-unapply").on("click",function(){miduoduo.user.id?$.put(api.gen("task-applicant"),{user_id:miduoduo.user.id,task_id:taskID},function(data){console.log(data),$(this).text("等待企业确认").removeClass("js-unapply").css("background","#a5abb2")}):showLoginDialog(!0)})}function showLoginDialog(action){var $obj=$(".login-dialog");action?$obj.show():$obj.hide()}require("zepto-ext");var urlHandle=require("../widget/url-handle"),tpl=require("../widget/tpl-engine"),api=require("../widget/api"),util=require("../widget/util"),taskID=urlHandle.getParams(window.location.search).task,url="task/"+taskID;$.getJSON(api.gen(url),function(data){console.log(data),$("body").append(tpl.parse("main-tpl",{data:data})),buildControlBar()}),$("body").on("click",".report",function(){util.href("/view/job/report.html?job_gid="+taskID)}).on("click",".store",function(){if(miduoduo.user.id){var $this=$(this);$this.hasClass("store-act")?($["delete"](api.gen("task-collection/"+taskID),function(data){console.log(data)}),$this.removeClass("store-act")):($.post(api.gen("task-collection"),{task_id:taskID},function(data){console.log(data)}),$this.addClass("store-act"))}else showLoginDialog(!0)}),$(".login-btn").on("click",function(){util.auth()}),$(".close-login-dialog").on("click",function(){$(this).parents(".login-dialog").hide()})});