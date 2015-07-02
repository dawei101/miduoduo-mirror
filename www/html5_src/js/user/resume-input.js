define(function(require, exports) {
    require("zepto");
    location.hash = '';
    var tpl = require("../widget/tpl-engine");
    $("body").append(tpl.parse("main1-tpl", {}));
    $("body").append(tpl.parse("main2-tpl", {}));

    $(".next-btn").on("click", function() {
        location.hash = "#main2";
    })

    $(window).on("hashchange", function() {
        if (location.hash == "") {
            $(".main1").show();
            $(".main2").hide();
        } else {
            $(".main1").hide();
            $(".main2").show();

        }


    })
});