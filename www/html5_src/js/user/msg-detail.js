define(function(require, exports) {
    require("zepto")
    var sLoad = require("../widget/scroll-load");
    var api = require("../widget/api");
    var tpl = require("../widget/tpl-engine");

    $("body").append(tpl.parse("msg-list-tpl", {}));
});