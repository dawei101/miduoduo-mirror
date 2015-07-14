define(function(require, exports) {
    require("zepto-ext");
    var api = require("../widget/api");
    var util = require("../widget/util");

    $(".btn-submit").on("click", function() {
        $.post(api.gen("contact-us"), {"content" : $(".content").val(), "phonenum" : $(".tel").val()}, function(data) {
            var msg = "";
            if (arguments[2].status == 422) {
                data.forEach(function(e) {
                    msg += e.message + "\n";
                });
                util.showTips(msg)
            } else {
                msg = "提交成功！"
                util.showTips(msg, function() {
                    util.pop();
                });
            }
        });
    })
});