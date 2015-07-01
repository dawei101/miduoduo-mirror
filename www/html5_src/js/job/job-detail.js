define(function(require, exports) {
    require("zepto");
    var tpl = require("../widget/tpl-engine");
    var api = require("../widget/api");
    $.getJSON(api.gen("task/143394256310412"), function(data) {
        console.log(data);
        $("body").append(tpl.parse("main-tpl", {"data" : data}));
    });
});