define(function(require,exports){require("zepto");var api=require("../widget/api");require("../widget/util");location.hash="";var tpl=require("../widget/tpl-engine");$("body").append(tpl.parse("main1-tpl",{})),$("body").append(tpl.parse("main2-tpl",{})),$(".next-btn").on("click",function(){location.hash="#main2"}),$(window).on("hashchange",function(){""==location.hash?($(".main1").show(),$(".main2").hide()):($(".main1").hide(),$(".main2").show())}),$(".sex").find("div").on("click",function(){$(this).addClass("sex-act").siblings().removeClass("sex-act")}),$(".sub2-con-val").on("click",function(){$(this).toggleClass("sub2-con-val-act")});var timeName=["morning","afternoon","evening"];$(".dateCol > .time").on("click",function(){var $this=$(this),classStr="time-act",dayIndex=$this.parent().index()+1,timeIndex=$this.index()-1,data={};$this.hasClass(classStr)?($this.removeClass(classStr),data[timeName[timeIndex]]=0):($this.addClass(classStr),data[timeName[timeIndex]]=1),$.put(api.gen("freetime/"+dayIndex),data,function(data){console.log(data)})}),$(".freetime-all").on("click",function(){$(".dateCol > .time").addClass("time-act"),$.post(api.gen("freetime/free-all"),{},function(data){console.log(data)})}),$(".js-sel-service-type").on("click",function(){$(".main2").hide(),$(".sel-job-type").show()}),$(".submit-btn").on("click",function(){var data={};$(".js-col").each(function(){data[$(this).attr("name")]=$(this).val()});var $sc=$(".js-special-col");data[$sc.attr("name")]=$sc.find(".sex-act").data("val"),data.phonenum=miduoduo.config.phone,console.log("简历",data),$.post(api.gen("resume"),data,function(data){console.log(data)})}),require("./resume-job-type")});