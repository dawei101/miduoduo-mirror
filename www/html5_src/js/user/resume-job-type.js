define(function(require, exports) {
    require("zepto")
    var api = require("../widget/api");
    var tpl = require("../widget/tpl-engine");
    $(".content").append(tpl.parse("job-type-list-tpl", {}));
});