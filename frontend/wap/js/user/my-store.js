define(function(require, exports, module) {
    require("zepto-ext");
    var tpl = require("../widget/tpl-engine");
    var sLoad = require("../widget/scroll-load");
    var api = require("../widget/api");
    var util = require("../widget/util");

    $(".tab").find("div").on("click", function() {
        $(this).addClass("act").siblings().removeClass("act");
        $(".no-data").hide();
        $(".jobs-container").empty();
        if ($(this).index() == 0) {
            sLoad.startWatch(api.gen('task-collection?expand=task&filters=[[">=","task.to_date","' + new Date().Format("yyyy-MM-dd") + '"]]'), {"page" : 1}, function(data) {
                $(".jobs-container").append(tpl.parse("job-list-tpl", {"jobs" : data.items}));
                setTimeout(function() {
                    if ($(".jobList").length == 0) {
                        $(".no-data").fadeIn();
                    }
                }, 200);
            });
        } else {
            sLoad.startWatch(api.gen('task-collection?expand=task&filters=[["<","task.to_date","' + new Date().Format("yyyy-MM-dd") + '"]]'), {"page" : 1}, function(data) {
                $(".jobs-container").append(tpl.parse("job-list-tpl", {"jobs" : data.items}));
                setTimeout(function() {
                    if ($(".jobList").length == 0) {
                        $(".no-data").fadeIn();
                    }
                }, 200);
            });
        }
    })
    $(".tab1").click();

    $(".jobs-container").on("click", "a", function(e) {
        e.preventDefault();
        util.href($(this).attr("href"));
    })
});