define(function(require,exports){function initState(){miduoduo.user.id&&($.pageInitGet(api.gen("task-applicant/"+taskID+"?expand=task"),function(data){if(data){var $obj=$(".control-btn");$obj.off("click"),0==data.status?$obj.text("等待企业确认").addClass("btn-wait-confirm"):10==data.status&&$obj.text("报名成功").addClass("btn-apply-success")}else;},"json"),$.pageInitGet(api.gen("task-collection/"+taskID),function(data){data&&$(".store").addClass("store-act").find("span").text("已收藏")},"json"))}function buildControlBar(){$(".control-btn").on("click",function(){function confirmCloseBtn(){window.cookie.remove(previousOptKey),duang.confirmClose()}var $this=$(this);miduoduo.user.id?miduoduo.user.resume?$.post(api.gen("task-applicant"),{user_id:miduoduo.user.id,task_id:taskID},function(data){$this.text("等待企业确认").addClass("btn-wait-confirm").off("click")}):duang.confirm({desc:"报名兼职需要填写简历！",leftBtnFn:function(){previousOptVal="apply",window.cookie.set(previousOptKey,previousOptVal),util.href("view/user/resume-input.html")},rightBtnFn:confirmCloseBtn,closeBtnFn:confirmCloseBtn}):(previousOptVal="apply",showLoginDialog(!0))}),$(".report").on("click",function(){miduoduo.user.id?util.href("view/job/report.html?job-gid="+taskID):(previousOptVal="report",showLoginDialog(!0))}),$(".store").on("click",function(){if(miduoduo.user.id){var $this=$(this);$this.hasClass("store-act")?($["delete"](api.gen("task-collection/"+taskID),function(data){}),$this.removeClass("store-act"),$this.find("span").html("收藏")):($.post(api.gen("task-collection"),{task_id:taskID},function(data){}),$this.addClass("store-act"),$this.find("span").text("已收藏"))}else previousOptVal="store",showLoginDialog(!0)});var nextOpt=window.cookie.get(previousOptKey);if(miduoduo.user.id&&nextOpt)switch(window.cookie.remove(previousOptKey),nextOpt){case"apply":$(".control-btn").click();break;case"store":$(".store").click();break;case"report":$(".report").click()}$(".share").on("click",function(){miduoduo.os.wx?($(".shade-biz").addClass("shade-top-bar").show(),$(".share-tips").show()):duang.toast("app端分享还未联调")})}function showLoginDialog(action){var $obj=$(".login-dialog");action?$obj.show():$obj.hide()}require("zepto-ext");var previousOptVal,urlHandle=require("../widget/url-handle"),tpl=require("../widget/tpl-engine"),api=require("../widget/api"),util=require("../widget/util"),duang=require("../widget/duang"),wxShare=require("../wechat/share"),taskID=urlHandle.getParams(window.location.search).task,url="task/"+taskID+"?expand=addresses",previousOptKey="previous_opt";window.MDDWeb.reload=function(){location.reload()},$.pageInitGet(api.gen(url),function(data){$("body").append(tpl.parse("main-tpl",{data:data})),miduoduo.os.wx&&wxShare.bind({title:$(".title-area").find(".title").text()}),initState(),buildControlBar()},"json"),$(".close-login-dialog").on("click",function(){$(this).parents(".login-dialog").hide(),window.cookie.remove(previousOptKey)}),$(".login-btn").find("a").on("click",function(e){if(window.cookie.set(previousOptKey,previousOptVal),miduoduo.os.app){e.preventDefault();var act=0;$(this).hasClass("go-reg")&&(act=1),window.MDDNative.auth({register:act})}}),$(".shade-biz").on("click",function(){$(this).hide(),$(".js-with-shade").hide()}),$("body").on("click",".more-address-btn",function(){$(this).hasClass("less-address-btn")?($(".more-address").hide(),$(this).removeClass("less-address-btn"),$(this).text("查看更多 >")):($(".more-address").show(),$(this).addClass("less-address-btn"),$(this).text("收回"))})});