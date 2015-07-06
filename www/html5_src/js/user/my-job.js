define(function(require, exports, module) {
    require("zepto");
    var tpl = require("../widget/tpl-engine");
    var sLoad = require("../widget/scroll-load");
    var api = require("../widget/api");
    var util = require("../widget/util");

    $(".tab").find("div").on("click", function() {
        var $this = $(this);
        $this.addClass("act").siblings().removeClass("act");
        var status = $this.data("status");
        $(".content").find(".list").empty();
        sLoad.startWatch(api.gen('task-applicant?expand=task&filters=[["=","status","' + status + '"]]'), {"page" : 1, "per-page" : 30}, function(data) {
            console.log(data);
            $(".content").find(".list").append(tpl.parse("job-list-tpl", {"jobs" : data.items, "showOthers" : true}));
        });
    });
    $(".tab1").click(); //默认显示第一个tab

    $(".content").on("click", ".report", function() {
        if (!$(this).hasClass("report-act")) {
            util.href("/view/job/report.html?job-gid=" + $(this).parent().data("gid"));
        }
    })
});