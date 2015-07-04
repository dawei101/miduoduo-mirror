define(function(require, exports) {
    require("zepto");
    var util = require("../widget/util");

    $(".js-btn").on("click", function() {
        util.href("/view/user/msg-detail.html?msg-type=" + $(this).data("type"));
    })
});