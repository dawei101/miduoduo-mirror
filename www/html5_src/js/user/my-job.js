define(function(require, exports, module) {
    require("zepto");
    var tpl = require("../widget/tpl-engine");
    var sLoad = require("../widget/scroll-load");
    var api = require("../widget/api");

    //职位列表，滚动加载
    sLoad.startWatch(api.gen("task"), {"page" : 1, "per-page" : 30}, function(data) {
        $(".content").find(".pullUp").before(tpl.parse("job-list-tpl", {"jobs" : data.items}));
    });
});