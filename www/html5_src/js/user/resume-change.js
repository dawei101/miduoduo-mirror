define(function(require, exports) {
    require("zepto-ext");
    var tpl = require("../widget/tpl-engine");
    var api = require("../widget/api");
    var util = require("../widget/util");

    document.addEventListener('WebViewJavascriptBridgeReady', function() {
        WebViewJavascriptBridge.defaultHandler(handle_action)
    }, false);
    //jsbridge 主动监听
    function handle_action(data, responseCallback) {
        var rst = {
            action: 'q_before_quit',
            result: {
                value: true
            }
        }
        util.cf({title : "注意", message : "确定放弃编辑吗？"}, function(data) {
            data = JSON.parse(data);
            if (data.result.value == 0) {
                rst.result.value = false;
            }
            responseCallback(rst);
        });
    };

    $.get(api.gen("resume?expand=service_types,freetimes,home_address,workplace_address"), function(data) {
        console.log(data);
        var user = data.items[0];
        $("body").append(tpl.parse("main-tpl", {"user" : user}));
        var $days = $(".dateTitle");
        var freeTimes = user.freetimes;
        freeTimes.forEach(function(e) {
            var $day = $days.eq(e.dayofweek - 1);
            var $times = $day.siblings();
            if (e.morning == 1) {
                $times.eq(0).addClass("time-act");
            }
            if (e.afternoon == 1) {
                $times.eq(1).addClass("time-act");
            }
            if (e.evening == 1) {
                $times.eq(2).addClass("time-act");
            }

        });

        //性别
        $(".sex").find("div").on("click", function() {
            $(this).addClass("sex-act").siblings().removeClass("sex-act");
        });
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
        //可兼职类型
        $(".js-sel-service-type").on("click", function() {
            //$(".main2, .main1").hide();
            $(".sel-job-type").show();
            var typeCodeStr = $(this).find("input").val();
            $(this).find("input").val("");
            if (typeCodeStr) {
                var typeCode = typeCodeStr.split(",");
                typeCode.forEach(function(e) {
                $(".type-item[data-code='" + e + "']").addClass("type-act");
                });
            }

        })
        //居住地点
        $(".js-set-address").on("click", function() {
            var $this = $(this);
            util.setAddress(function(data) {
                alert("app返回的地址信息：" + JSON.stringify(data));
                data = JSON.parse(data);
                $this.find("input").val(data.address);
                $.post(api.gen("address"), data, function(data) {
                    console.log(data);
                });
            });
        })
        require("./resume-job-type");

        //更新
        $(".submit-btn").on("click", function() {
            var data = {};
            $(".js-col").each(function() {
                data[$(this).attr("name")] = $(this).val();
            });

            var $sc = $(".js-special-col");
            data[$sc.attr("name")] = $sc.find(".sex-act").data("val");
            data["phonenum"] = miduoduo.user.phone;
            console.log("简历",data);
            $.put(api.gen("resume/" + miduoduo.user.id), data, function(data) {
                util.showTips("修改成功！");
            })
        })
    });

});