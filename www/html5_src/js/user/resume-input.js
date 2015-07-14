define(function(require, exports) {
    require("zepto-ext");
    var api = require("../widget/api");
    var util = require("../widget/util");
    var calendar = require("../widget/calendar");

    WebViewJavascriptBridge.defaultHandler(handle_action);
    //jsbridge 主动监听
    function handle_action(data, responseCallback) {
        var rst = {
            action: 'q_before_quit',
            result: {
                value: true
            }
        }
        if (location.hash != "") {
            location.hash = "";
            rst.result.value = false;
            responseCallback(rst);
        } else {
            util.cf({title : "注意", message : "确定放弃编辑吗？"}, function(data) {
                alert("confirm对话框：" + data + " "  + JSON.stringify(rst));
                data = JSON.parse(data);
                if (data.result.value == 0) {
                    rst.result.value = false;
                }
                responseCallback(rst);
            });
        }

    };

    location.hash = '';
    var tpl = require("../widget/tpl-engine");
    $("body").append(tpl.parse("main1-tpl", {}));
    $("body").append(tpl.parse("main2-tpl", {}));
    calendar.initCalendar();

    /*$(".next-btn").on("click", function() {
        location.hash = "#main2";
    })

    $(window).on("hashchange", function() {
        if (location.hash == "") {
            $(".main1").show();
            $(".main2").hide();
        } else {
            $(".main1").hide();
            $(".main2").show();

        }
    })*/

    //生日
    $(".js-birthday").on("click", function() {
        $(".calendar-widget, .shade-widget").show(300);

    });
    //性别
    $(".sex").find("div").on("click", function() {
        $(this).addClass("sex-act").siblings().removeClass("sex-act");
    })
    //更在意的
    $(".sub2-con-val").on("click", function() {
        $(this).toggleClass("sub2-con-val-act");
    });
    //时间表事件
    var timeName = ["morning", "afternoon", "evening"];
    $(".dateCol > .time").on("click", function() {
        var $this = $(this);
        var classStr = "time-act";
        var dayIndex = $this.parent().index() + 1;
        var timeIndex = $this.index() - 1;
        var data = { };
        if($this.hasClass(classStr)) {
            $this.removeClass(classStr);
            data[timeName[timeIndex]] = 0;
        } else {
            $this.addClass(classStr);
            data[timeName[timeIndex]] = 1;
        }
        $.put(api.gen("freetime/" + dayIndex), data, function(data) {
            console.log(data);
        });
    });
    $(".freetime-all").on("click", function() {
        $(".dateCol > .time").addClass("time-act");
        $.post(api.gen("freetime/free-all"), {}, function(data) {
            console.log(data);
        })
    })
    //可兼类型
    $(".js-sel-service-type").on("click", function(e) {
        $(".sel-job-type").show();
        /*var typeCodeStr = $(this).find("input").val();
        if (typeCodeStr) {
            var typeCode = typeCodeStr.split(",");
            typeCode.forEach(function(e) {
                $(".type-item[data-code='" + e + "']").addClass("type-act");
            });
        }*/

    })
    //居住地点
    $(".js-set-address").on("click", function() {
        var $this = $(this);
        util.setAddress(function(data) {
            if (!data) {
                return;
            }
            data = JSON.parse(data);
            $this.find("input").val(data.address);
            $.post(api.gen("address"), data, function(data) {
                console.log(data);
            });
        });
    })
    //提交
    $(".submit-btn").on("click", function() {
        var data = {};
        $(".js-col").each(function() {
            data[$(this).attr("name")] = $(this).val();
        });

        var $sc = $(".js-special-col");
        data[$sc.attr("name")] = $sc.find(".sex-act").data("val");
        console.log("简历",data);
        $.post(api.gen("resume"), data, function(data) {
            //验证失败
            if (arguments[2].status == 422) {
                var tipsArr = data
                var tipsStr = "";
                tipsArr.forEach(function(e) {
                    tipsStr += e.message + "\n";
                });
                if (window.WebViewJavascriptBridge) {
                    var opts = {
                        action: 'b_toast_alert',
                        data: {
                            'message' : tipsStr,
                            'disappear_delay' : 2000
                        }
                    }
                    window.WebViewJavascriptBridge.send(opts, null);
                } else {
                    alert(tipsStr);
                }
                return;
            }
            util.showTips("提交成功", function() {
                util.pop();
            })

        })
    })

    require("./resume-job-type");
});