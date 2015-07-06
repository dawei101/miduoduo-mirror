define(function(require, exports) {
    require("zepto");
    var urlHandle = require("../widget/url-handle");
    var tpl = require("../widget/tpl-engine");
    var api = require("../widget/api");
    var util = require("../widget/util");
    var taskID = urlHandle.getParams(window.location.search).task;
    var url = "task/" + taskID;
    $.getJSON(api.gen(url), function(data) {
        console.log(data);
        $("body").append(tpl.parse("main-tpl", {"data" : data}));
    });

    $(".control-btn").on("click", function() {
        console.log();
    })

    $("body").on("click", ".report", function() { //举报
        if (!$(this).hasClass("report-act")) {
            util.href("/view/job/report.html?job_gid=" + taskID)
        }
    }).on("click", ".store", function() {
        var $this = $(this);
        if ($this.hasClass("store-act")) {
            $.put(api.gen("task-collection"), {user_id : miduoduo.user.id, task_id : taskID}, function(data) {
                console.log(data);
            });
            $this.removeClass("store-act");
        } else {
            $.delete(api.gen("task-collection/" + taskID), function(data) {
                console.log(data);
            });
            $this.addClass("store-act");
        }


    })

});