define(function(require, exports) {
    require("zepto-ext");
    var urlHandle = require("../widget/url-handle");
    var tpl = require("../widget/tpl-engine");
    var api = require("../widget/api");
    var util = require("../widget/util");
    var taskID = urlHandle.getParams(window.location.search).task;
    var url = "task/" + taskID;
    var noResume; //是否填写过简历
    $.pageInitGet(api.gen(url), function(data) {
        console.log(data);
        $("body").append(tpl.parse("main-tpl", {"data" : data}));
        buildControlBar();
    }, "json");

    if (miduoduo.user.id) {
        $.pageInitGet(api.gen("resume?expand=service_types,freetimes,home_address,workplace_address"), function(data) {
            console.log(data);
            if (data.items && data.items.length <= 0) { //显示填写简历弹窗
                noResume = true;
            }
        }, "json");
    }

    //构建控制栏
    function buildControlBar() {
        if (miduoduo.user.id) {
            var reqOver = 2;
            $.get(api.gen('task-applicant/' + taskID + '?expand=task'), function(data) {
                if (!data) { //没有报名
                } else {
                    var $obj = $(".control-btn");
                    $obj.off("click");
                    if (data.status == 0) {
                        $obj.text("等待企业确认").css("background", "#a5abb2");
                    } else if(data.status == 10) {
                        $obj.text("报名成功").css("background", "#ff7b5d");

                    }
                }
                showBarWhenReqOver();
            }, "json");
            $.get(api.gen('task-collection/' + taskID), function(data) {
                if (!data) {
                } else {
                    $(".store").addClass("store-act").find("span").text("已收藏");
                }
                showBarWhenReqOver();
            }, "json");

            function showBarWhenReqOver() {
                reqOver--;
                if (reqOver == 0) {
                    $(".part5").show();
                }
            }
        } else {
            $(".part5").show();
        }

        $(".control-btn").on("click", function() {
            var $this = $(this);
            if (miduoduo.user.id) {
                if (noResume) {
                    util.cf({title : "注意", message : "报名兼职需要填写简历！"}, function(data) {
                        if (data.result.value == 1) {
                            util.href("view/user/resume-input.html");
                        }
                    });
                } else {
                    $.post(api.gen("task-applicant"), {user_id : miduoduo.user.id, task_id: taskID}, function(data) {
                        console.log(data);
                        $this.text("等待企业确认").css("background", "#a5abb2").off("click");
                    });
                }
            } else {
                showLoginDialog(true);
            }
        })
    }

    $("body").on("click", ".report", function() { //举报
        if (miduoduo.user.id) {
            util.href("view/job/report.html?job_gid=" + taskID)
        } else {
            showLoginDialog(true);
        }

    }).on("click", ".store", function() {
        if (miduoduo.user.id) {
            var $this = $(this);
            if (!$this.hasClass("store-act")) {
                $.post(api.gen("task-collection"), {task_id : taskID}, function(data) {
                    console.log(data);
                });
                $this.addClass("store-act");
                $this.find("span").text("已收藏");
            } else {
                $.delete(api.gen("task-collection/" + taskID), function(data) {
                    console.log(data);
                });
                $this.removeClass("store-act");
                $this.find("span").html("收藏");
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
    $(".go-login").on("click", function() {
        util.auth("view/user/resume-input.html?login=1");
    });
    $(".go-reg").on("click", function() {
        util.reg("view/user/resume-input.html?login=1");
    });
    $(".close-login-dialog").on("click", function() {
        $(this).parents(".login-dialog").hide();
    })


});