define(function(require, exports, module) {
    require("zepto");
    var tpl = require("../widget/tpl-engine");
    var sLoad = require("../widget/scroll-load");
    var api = require("../widget/api");
    var util = require("../widget/util");

    $(".tab").find("div").on("click", function() {
        $(this).addClass("act").siblings().removeClass("act");
        $(".content").find(".list").empty();
        if ($(this).index() == 0) {
            sLoad.startWatch(api.gen('task-collection?expand=task&filters=[[">=","task.to_date","' + new Date().Format("yyyy-MM-dd") + '"]]'), {"page" : 1, "per-page" : 30}, function(data) {
                $(".content").find(".list").append(tpl.parse("job-list-tpl", {"jobs" : data.items}));
            });
        } else {
            sLoad.startWatch(api.gen('task-collection?expand=task&filters=[["<","task.to_date","' + new Date().Format("yyyy-MM-dd") + '"]]'), {"page" : 1, "per-page" : 30}, function(data) {
                console.log(data);
                $(".content").find(".list").append(tpl.parse("job-list-tpl", {"jobs" : data.items}));
            });
        }
    })
    $(".tab1").click();
});