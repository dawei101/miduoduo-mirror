define(function(require, exports, module) {
    require("zepto");
    var sLoad = require("../widget/scroll-load");
    var api = require("../widget/api");
    var tpl = require("../widget/tpl-engine");
    var url = "task";
    //职位列表，滚动加载
    sLoad.startWatch(api.gen(url), {"page" : 1, "per-page" : 30}, function(data) {
        $(".content").find(".pullUp").before(tpl.parse("job-list-tpl", {"jobs" : data.items}));
    });


    $(".js-district-btn").on("tap", function() {
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

    $(".js-job-type-btn").on("tap", function() {
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

    $(".js-sort-btn").on("tap", function() {
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

});
