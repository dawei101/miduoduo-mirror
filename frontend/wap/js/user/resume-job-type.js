define(function(require, exports) {
    require("zepto")
    var urlHandle = require("../widget/url-handle")
    var api = require("../widget/api");
    var tpl = require("../widget/tpl-engine");
    $.get(api.gen("service-type"), function(data) {
        $("body").append(tpl.parse("job-type-list-tpl", { list : data.items, as : ""}));
    }, "json")
    //选择类型
    $("body").on("click", ".type-content .type-item" ,function() {
        var $this = $(this);
        var typeCode =  $this.data("code");
        if ($this.hasClass("type-act")) {
            $this.removeClass("type-act");
            $.delete(api.gen("user-service-type/" + typeCode), function(data) {
                console.log(data);
            });

        } else {
            $this.addClass("type-act");
            $.post(api.gen("user-service-type"), {"service_type_id" : typeCode}, function(data) {
                console.log(data);
            });
        }
    })

    //点击返回时，与父页面有偶合的
    $("body").on("click", ".type-submit", function() {
        var typesStr = "";
        var $selType = $(".type-act");
        $selType.each(function() {
            typesStr += " " + $(this).text();
        });
        //简历表单--可兼类别对象
        var $st = $(".js-sel-service-type");
        if ($selType.length > 0) {
            $st.find("input").hide();
        } else {
            $st.find("input").show();
        }
        $st.find("span").text(typesStr).show();
        $(".sel-job-type").hide();
        $(".main2").show();

    })
});