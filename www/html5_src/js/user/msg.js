define(function(require, exports) {
    require("zepto-ext");
    var util = require("../widget/util");
    var api = require("../widget/api");

    $(".js-btn").on("click", function() {
        util.href("view/user/msg-detail.html?msg-type=" + $(this).data("type"));
    })

    //获取未读消息数
    $.pageInitGet(api.gen('message?filters=[["=", "read_flag", 0]]&per-page=1'), function(data) {
        if (data._meta.totalCount > 0) {
            $(".job-tips").text(data._meta.totalCount).css("display", "inline-block");
        }
    });
    /*$.get(api.gen('sys-message?filters=[["=", "read_flag", 0]]&per-page=1'), function(data) {
        if (data._meta.totalCount > 0) {
            $(".sys-tips").text(data._meta.totalCount).css("display", "inline-block");
        }
    });*/
});