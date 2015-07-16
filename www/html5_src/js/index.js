define(function(require, exports, module) {
    require("zepto-ext");
    require("widget/touchSlide");
    var tpl = require("widget/tpl-engine");
    var sLoad = require("widget/scroll-load");
    var api = require("widget/api");
    var util = require("widget/util");

    window.MDD = {
        reload : function() {
            location.reload();
        }
    }

    //轮播
    var banners = [
        {url: "view/job/job-detail.html?task=476", imgSrc : miduoduo.basePath.picUrl + "/index/banner2.png"},
        {"tag" : "handle", url: "", imgSrc : miduoduo.basePath.picUrl + "/index/banner0.png"},

    ]
    $(".imageSlide").html(tpl.parse("banner-slide-tpl", {"banners" : banners}));
    $("#bannerSlider").touchSlide();

    $("#bannerSlider").on("click", "a", function(e) {
        e.preventDefault();
        var tag = $(this).data("tag");
        if (tag == "handle") {
            if (!miduoduo.user.id) {
                util.auth();
            }
        } else {
            util.href($(this).attr("href"));
        }
    });

    $(".top-nav > div").on("click", function() {
        util.href($(this).data("url"));
    })

    //职位列表，滚动加载
    sLoad.startWatch(api.gen("task"), {"page" : 1}, function(data) {
        $(".jobs-container").append(tpl.parse("job-list-tpl", {"jobs" : data.items}));

    });

    $(".jobs-container").on("click", "a", function(e) {
        e.preventDefault();
        util.href($(this).attr("href"));
    })
});