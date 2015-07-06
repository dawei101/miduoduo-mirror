define(function(require, exports) {
    require("zepto");
    var tpl = require("../widget/tpl-engine");
    var api = require("../widget/api")
    $("body").append(tpl.parse("main-tpl", {}));

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
        $(".main2, .main1").hide();
        $(".sel-job-type").show();
        /*var typeCodeStr = $(this).find("input").val();
         if (typeCodeStr) {
         var typeCode = typeCodeStr.split(",");
         typeCode.forEach(function(e) {
         $(".type-item[data-code='" + e + "']").addClass("type-act");
         });
         }*/

    })
    require("./resume-job-type");
});