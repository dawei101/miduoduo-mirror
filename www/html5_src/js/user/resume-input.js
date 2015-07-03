define(function(require, exports) {
    require("zepto");
    var api = require("../widget/api");
    location.hash = '';
    var tpl = require("../widget/tpl-engine");
    $("body").append(tpl.parse("main1-tpl", {}));
    $("body").append(tpl.parse("main2-tpl", {}));

    $(".next-btn").on("click", function() {
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
    })

    $(".sex").find("div").on("click", function() {
        $(this).addClass("sex-act").siblings().removeClass("sex-act");
    })
    //更在意的
    $(".sub2-con-val").on("click", function() {
        $(this).toggleClass("sub2-con-val-act");
    });
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
});