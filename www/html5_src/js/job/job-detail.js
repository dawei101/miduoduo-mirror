define(function(require, exports) {
    require("zepto-ext");
    var urlHandle = require("../widget/url-handle");
    var tpl = require("../widget/tpl-engine");
    var api = require("../widget/api");
    var util = require("../widget/util");
    var taskID = urlHandle.getParams(window.location.search).task;
    var url = "task/" + taskID;
    $.getJSON(api.gen(url), function(data) {
        console.log(data);
        $("body").append(tpl.parse("main-tpl", {"data" : data}));
        buildControlBar();
    });

    //构建控制栏
    function buildControlBar() {
        if (false && miduoduo.user.id) {
            var reqOver = 2;
            $.get(api.gen('task-applicant/' + taskID + '?expand=task'), function(data) {
                console.log(data);
            });
            $.get(api.gen('task-collection/' + taskID), function(data) {
                console.log(11,data);
            })

            function showBarWhenReqOver() {
                reqOver--;
                if (reqOver == 0) {
                    $(".part5").show();
                }
            }
        } else {
            $(".part5").show();
        }

        $(".js-unapply").on("click", function() {
            if (miduoduo.user.id) {
                $.put(api.gen("task-applicant"), {user_id : miduoduo.user.id, task_id: taskID}, function(data) {
                    console.log(data);
                    $(this).text("等待企业确认").removeClass("js-unapply").css("background", "#a5abb2");
                });
            } else {
                showLoginDialog(true);
            }
        })
    }

    $("body").on("click", ".report", function() { //举报
        util.href("/view/job/report.html?job_gid=" + taskID)
    }).on("click", ".store", function() {
        if (miduoduo.user.id) {
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
        } else {
            showLoginDialog(true);
        }
    })

    //显示登陆弹层
    function showLoginDialog(action) {
        var $obj = $(".login-dialog");
        action ? $obj.show() : $obj.hide();

    }
    $(".login-btn").on("click", function() {
        util.auth();
    });
    $(".close-login-dialog").on("click", function() {
        $(this).parents(".login-dialog").hide();
    })


});