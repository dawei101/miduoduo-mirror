define(function(require, exports) {
    require("zepto");
    var tpl = require("../widget/tpl-engine");
    $("body").append(tpl.parse("main-tpl", {}));
});