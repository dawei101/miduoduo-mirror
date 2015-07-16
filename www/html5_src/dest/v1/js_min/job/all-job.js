define(function(require,exports,module){function buildFilterParam($this){$this.parent().scrollTop(0).hide();var allTag=$this.data("all");if(allTag)expandStr=expandStr.replace(allTag+",",""),delete filtersObj[allTag];else{var paramArr=$this.data("uid").split(":"),p0=paramArr[0],p1=paramArr[1],p2=paramArr[2];expandStr=expandStr.replace(p0+",","").concat(p0+","),filtersObj[p0]=["=",p1,p2]}var btnClass=$this.parent().data("btn");$("."+btnClass).text($this.text()),buildJobList()}function buildJobList(){function handleFiltersObj(obj){console.log("filtersObj",obj);var tempArr=[];for(var i in obj)tempArr.push(obj[i]);return JSON.stringify(tempArr)}$(".jobs-container").empty(),$(".no-data").hide();var urlParam={page:1,expand:expandStr,filters:handleFiltersObj(filtersObj)};sLoad.startWatch(api.gen(url),urlParam,function(data){$(".jobs-container").append(tpl.parse("job-list-tpl",{jobs:data.items})),setTimeout(function(){0==$(".jobList").length&&$(".no-data").fadeIn()},200)})}require("zepto-ext");var sLoad=require("../widget/scroll-load"),api=require("../widget/api"),tpl=require("../widget/tpl-engine"),util=require("../widget/util"),urlHandle=require("../widget/url-handle"),urlParam=urlHandle.getParams(window.location.search),filtersObj={},expandStr="";urlParam.district&&(filtersObj.district=["=","district_id",urlParam.district],expandStr+="district,"),urlParam.type&&(filtersObj["service-type"]=["=","service_type_id",urlParam.type],expandStr+="service-type,");var url="task";$.pageInitGet(api.gen("service-type"),function(data){data&&data.items.length>0&&($("body").append(tpl.parse("job-type-list-tpl",{list:data.items})),urlParam.type&&$(".js-job-type-btn").text($("#type-"+urlParam.type).text()))},"json"),$.pageInitGet(api.gen('district?filters=[["=",%20"parent_id",3]]'),function(data){data&&data.items.length>0&&($("body").append(tpl.parse("district-list-tpl",{list:data.items})),urlParam.district&&$(".js-district-btn").text($("#district-"+urlParam.district).text()))},"json"),$("body").append(tpl.parse("sort-list-tpl",null)),$(".js-district-btn").on("click",function(){$(this).toggleClass("filter-btn-act").siblings().removeClass("filter-btn-act");var $obj=$(".district-list");$obj.siblings(".js-top-filter-btn").hide(),$obj.toggle()}),$(".js-job-type-btn").on("click",function(){$(this).toggleClass("filter-btn-act").siblings().removeClass("filter-btn-act");var $obj=$(".job-type-list");$obj.siblings(".js-top-filter-btn").hide(),$obj.toggle()}),$(".js-sort-btn").on("click",function(){$(this).toggleClass("filter-btn-act").siblings().removeClass("filter-btn-act");var $obj=$(".sort-list");$obj.siblings(".js-top-filter-btn").hide(),$obj.toggle()}),$("body").on("click",".district-list li",function(){$(".job-filter>a").removeClass("filter-btn-act"),buildFilterParam($(this))}).on("click",".job-type-list li",function(){$(".job-filter>a").removeClass("filter-btn-act"),buildFilterParam($(this))}).on("click",".sort-list li",function(){$(".job-filter>a").removeClass("filter-btn-act"),$(this).parent().hide().scrollTop(0)}),buildJobList(),$(".jobs-container").on("click","a",function(e){e.preventDefault(),util.href($(this).attr("href"))})});