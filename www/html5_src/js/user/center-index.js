define(function(require, exports) {
    require("zepto");
    var api = require("../widget/api");
    var util = require("../widget/util");
    $(".item").on("click", function(e) {
        e.preventDefault();
        util.href($(this).attr("href"));
    });
});