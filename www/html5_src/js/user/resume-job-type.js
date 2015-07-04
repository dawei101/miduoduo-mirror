define(function(require, exports) {
    require("zepto")
    var urlHandle = require("../widget/url-handle")
    var api = require("../widget/api");
    var tpl = require("../widget/tpl-engine");
    //已经选过的项
    var alreadySelected = urlHandle.getParams(window.location.search).service_type;
    $.get(api.gen("service-type"), function(data) {
        console.log(data);
        $(".content").append(tpl.parse("job-type-list-tpl", { list : data.items, as : alreadySelected}));
    }, "json")
    //选择类型
    $("body").on("click", ".item" ,function() {
        var $this = $(this);
        var typeCode =  $this.data("code");
        if ($this.hasClass("act")) {
            $this.removeClass("act");
            $.delete(api.gen("user-service-type/" + typeCode), function(data) {
                console.log(data);
            });

        } else {
            $this.addClass("act");
            $.post(api.gen("user-service-type"), {"service_type_id" : typeCode}, function(data) {
                console.log(data);
            });
        }
    })

});