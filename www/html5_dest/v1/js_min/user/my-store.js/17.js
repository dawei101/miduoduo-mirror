define(function(require,exports,module){require("zepto-ext");var tpl=require("../widget/tpl-engine"),sLoad=require("../widget/scroll-load"),api=require("../widget/api"),util=require("../widget/util"),urlHandle=require("../widget/url-handle"),urlParam=urlHandle.getParams(window.location.search),perPage=50,tabIndex=1;$(".tab").find("div").on("click",function(){$(this).addClass("act").siblings().removeClass("act"),$(".no-data").hide(),$(".jobs-container").empty(),tabIndex=$(this).index()+1;var sqlOpt;sqlOpt=0==$(this).index()?">=":"<";var apiParam={page:1};urlParam.frame&&(apiParam["per-page"]=urlParam.frame*perPage,delete urlParam.frame),sLoad.startWatch(api.gen('task-collection?expand=task&filters=[["'+sqlOpt+'","task.to_date","'+(new Date).Format("yyyy-MM-dd")+'"]]'),apiParam,function(data){apiParam["per-page"]!=perPage&&(apiParam.page=apiParam["per-page"]/perPage+1,apiParam["per-page"]=perPage),$(".jobs-container").append(tpl.parse("job-list-tpl",{jobs:data.items})),setTimeout(function(){urlParam.pos&&(window.scrollTo(0,urlParam.pos),delete urlParam.pos),0==$(".jobs-container>a").length&&$(".no-data").fadeIn()},200)})}),urlParam.tab?$(".tab"+urlParam.tab).click():$(".tab1").click(),$(".jobs-container").on("click","a",function(e){history.replaceState("restoreFilter","页面内容",util.addUrlParam(window.location.href.replace(/[&]?tab=.*$/,""),"tab="+tabIndex+"&pos="+document.body.scrollTop+"&frame="+Math.ceil(($(this).index()+1)/perPage)))})});