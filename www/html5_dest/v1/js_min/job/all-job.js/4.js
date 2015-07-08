define(function(require,exports,module){function buildFilterParam($this){$this.parent().hide();var allTag=$this.data("all");if(allTag)expandStr=expandStr.replace(allTag+",",""),delete filtersObj[allTag];else{var paramArr=$this.data("uid").split(":"),p0=paramArr[0],p1=paramArr[1],p2=paramArr[2];expandStr=expandStr.replace(p0+",","").concat(p0+","),filtersObj[p0]=["=",p1,p2]}var btnClass=$this.parent().data("btn");$("."+btnClass).text($this.text()),buildJobList()}function buildJobList(){function handleFiltersObj(obj){var tempArr=[];for(var i in obj)tempArr.push(obj[i]);return JSON.stringify(tempArr)}$(".jobList").remove();var urlParam={page:1,"per-page":30,expand:expandStr,filters:handleFiltersObj(filtersObj)};sLoad.startWatch(api.gen(url),urlParam,function(data){$(".content").find(".pullUp").before(tpl.parse("job-list-tpl",{jobs:data.items}))})}require("zepto");var sLoad=require("../widget/scroll-load"),api=require("../widget/api"),tpl=require("../widget/tpl-engine"),util=require("../widget/util"),url="task";$(".js-district-btn").on("click",function(){var _this=$(this)[0];if(_this.isLoad||_this.notLoadOver){var $obj=$(".district-list");$obj.siblings(".js-top-filter-btn").hide(),$obj.toggle()}else _this.notLoadOver=!0,$.get(api.gen('district?filters=[["=",%20"parent_id",3]]'),function(data){data&&data.items.length>0?($(".js-top-filter-btn").hide(),$("body").append(tpl.parse("district-list-tpl",{list:data.items})),_this.isLoad=!0):console.error("加载区域列表出错",data),_this.notLoadOver=!1},"json")}),$(".js-job-type-btn").on("click",function(){var _this=$(this)[0];if(_this.isLoad||_this.notLoadOver){var $obj=$(".job-type-list");$obj.siblings(".js-top-filter-btn").hide(),$obj.toggle()}else _this.notLoadOver=!0,$.getJSON(api.gen("service-type"),function(data){data&&data.items.length>0?($(".js-top-filter-btn").hide(),$("body").append(tpl.parse("job-type-list-tpl",{list:data.items})),_this.isLoad=!0):console.error("加载区域列表出错",data),_this.notLoadOver=!1})}),$(".js-sort-btn").on("click",function(){var _this=$(this)[0];if(_this.isLoad){var $obj=$(".sort-list");$obj.siblings(".js-top-filter-btn").hide(),$obj.toggle()}else _this.isLoad=!0,$("body").append(tpl.parse("sort-list-tpl",null))});var expandStr="",filtersObj={};$("body").on("click",".district-list li",function(){buildFilterParam($(this))}).on("click",".job-type-list li",function(){buildFilterParam($(this))}).on("click",".sort-list li",function(){$(this).parent().hide()}),buildJobList(),$(".content").on("click","a",function(e){e.preventDefault(),util.href($(this).attr("href"))})});