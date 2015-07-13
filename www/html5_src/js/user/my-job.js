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
        $(".no-data").hide();
        $(".jobs-container").empty();
        sLoad.startWatch(api.gen('task-applicant?expand=task&filters=[["=","status","' + status + '"]]'), {"page" : 1}, function(data) {
            $(".jobs-container").append(tpl.parse("job-list-tpl", {"jobs" : data.items, "showOthers" : true}));
            setTimeout(function() {
                if ($(".jobList").length == 0) {
                    $(".no-data").fadeIn();
                }
            }, 200)
        });
    });
    $(".tab1").click(); //默认显示第一个tab

    $(".jobs-container").on("click", ".report", function(e) {
        e.preventDefault();
        util.href("view/job/report.html?job-gid=" + $(this).parent().data("gid"));
    })

    $(".jobs-container").on("click", "a", function(e) {
        e.preventDefault();
        util.href($(this).attr("href"));
    })
});