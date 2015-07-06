define(function(require, exports) {
    require("zepto");
    var tpl = require("../widget/tpl-engine");
    var api = require("../widget/api");
   /* $.get(api.gen("resume/"), function(data) {
        $("body").append(tpl.parse("main-tpl", {user : data}));
    });*/
    $("body").append(tpl.parse("main-tpl", {user : {}}));

});