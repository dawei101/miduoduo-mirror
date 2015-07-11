define(function(require, exports, module) {
    require("zepto-ext");
    var sLoad = require("../widget/scroll-load");
    var api = require("../widget/api");
    var tpl = require("../widget/tpl-engine");
    var util = require("../widget/util")
    var url = "task";

    $(".js-district-btn").on("click", function() {
        var _this = $(this)[0];
        if (!_this.isLoad && !_this.notLoadOver) {
            _this.notLoadOver = true;
            //加载区域列表
            $.get(api.gen('district?filters=[["=",%20"parent_id",3]]'), function(data) {
                if (data && data.items.length > 0) {
                    $(".js-top-filter-btn").hide();
                    $("body").append(tpl.parse("district-list-tpl", {list : data.items}));
                    _this.isLoad = true;
                } else {
                    console.error("加载区域列表出错", data);
                }
                _this.notLoadOver = false;
            }, "json")
        } else {
            var $obj = $(".district-list");
            $obj.siblings(".js-top-filter-btn").hide();
            $obj.toggle();
        }

    });

    $(".js-job-type-btn").on("click", function() {
        var _this = $(this)[0];
        if (!_this.isLoad && !_this.notLoadOver) {
            _this.notLoadOver = true;
            $.getJSON(api.gen("service-type"), function(data) {
                if (data && data.items.length > 0) {
                    $(".js-top-filter-btn").hide();
                    $("body").append(tpl.parse("job-type-list-tpl", {list : data.items}));
                    _this.isLoad = true;
                } else {
                    console.error("加载区域列表出错", data);
                }
                _this.notLoadOver = false;
            })
        } else {
            var $obj = $(".job-type-list");
            $obj.siblings(".js-top-filter-btn").hide();
            $obj.toggle();

        }
    })

    $(".js-sort-btn").on("click", function() {
        var _this = $(this)[0];
        if (!_this.isLoad) {
            _this.isLoad = true;
            $("body").append(tpl.parse("sort-list-tpl",null));
        } else {
           var $obj = $(".sort-list");
            $obj.siblings(".js-top-filter-btn").hide();
            $obj.toggle();
        }
    });

    var expandStr = "";
    var filtersObj = {};
    $("body").on("click", ".district-list li", function() {

        buildFilterParam($(this));
    }).on("click", ".job-type-list li", function() {
        buildFilterParam($(this));
    }).on("click", ".sort-list li", function() {
        $(this).parent().hide();
    })

    function buildFilterParam($this) {
        $this.parent().hide();
        var allTag = $this.data("all");
        if(allTag) {
            expandStr = expandStr.replace(allTag+",", "");
            delete  filtersObj[allTag];
        } else {
            var paramArr = $this.data("uid").split(":");
            var p0 = paramArr[0];
            var p1 = paramArr[1];
            var p2 = paramArr[2];
            expandStr = expandStr.replace(p0+",", "").concat(p0+",");
            filtersObj[p0] = ["=", p1, p2];
        }
        var btnClass = $this.parent().data("btn");
        $("." + btnClass).text($this.text());

        buildJobList();
    }

    buildJobList();
    function buildJobList() {
        $(".jobList").remove();
        var urlParam = {"page" : 1, "per-page" : 30, "expand" : expandStr, "filters" : handleFiltersObj(filtersObj)}
        //职位列表，滚动加载
        sLoad.startWatch(api.gen(url), urlParam, function(data) {
            $(".content").find(".pullUp").before(tpl.parse("job-list-tpl", {"jobs" : data.items}));
        });

        function handleFiltersObj(obj) {
            var tempArr = [];
            for (var i in obj) {
                tempArr.push(obj[i]);
            }
            return JSON.stringify(tempArr);
        }
    }

    $(".content").on("click", "a", function(e) {
        e.preventDefault();
        util.href($(this).attr("href"));
    })

});
