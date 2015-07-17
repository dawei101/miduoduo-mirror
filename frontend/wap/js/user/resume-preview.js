define(function(require, exports) {
    require("zepto-ext");
    var tpl = require("../widget/tpl-engine");
    var api = require("../widget/api");
    var util = require("../widget/util");
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
    });

    $("body").on("click", ".submit-btn", function() {
        util.href("view/user/resume-change.html");
    })

});