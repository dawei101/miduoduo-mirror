define(function(require, exports) {
    require("zepto-ext")
    var sLoad = require("../widget/scroll-load");
    var api = require("../widget/api");
    var tpl = require("../widget/tpl-engine");
    var urlHandle = require("../widget/url-handle");
    var msgType = urlHandle.getParams(window.location.search)["msg-type"];
    $.pageInitGet(api.gen(msgType), function(data) {
        if (!data.items || data.items.length < 1) {
            $(".tips").fadeIn();
        } else {
            $("body").append(tpl.parse("msg-list-tpl", {msgs : data.items}));
        }
    })

    $.post(api.gen(msgType + "/update-all"), null, function(data) {
        console.log("消息设为已读:" + data);
    });

});