define(function(require, exports) {
    require("zepto")
    var sLoad = require("../widget/scroll-load");
    var api = require("../widget/api");
    var tpl = require("../widget/tpl-engine");
    var urlHandle = require("../widget/url-handle");
    var msgType = urlHandle.getParams(window.location.search)["msg-type"];
    $.get(api.gen(msgType), function(data) {
        console.log(data);
        $("body").append(tpl.parse("msg-list-tpl", {}));
    })


});