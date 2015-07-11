define(function(require, exports, module) {
    require("zepto-ext");
    require("widget/touchSlide");
    var tpl = require("widget/tpl-engine");
    var sLoad = require("widget/scroll-load");
    var api = require("widget/api");
    var util = require("widget/util");

    //轮播
    var banners = [
        {url: "", imgSrc : miduoduo.basePath.picUrl + "/index/banner1.jpg"},
        {url: "", imgSrc : miduoduo.basePath.picUrl + "/index/banner2.jpg"},
        {url: "", imgSrc : miduoduo.basePath.picUrl + "/index/banner1.jpg"},
        {url: "", imgSrc : miduoduo.basePath.picUrl + "/index/banner2.jpg"}

    ]
    $(".imageSlide").html(tpl.parse("banner-slide-tpl", {"banners" : banners}));
    $("#bannerSlider").touchSlide();

    $(".top-nav .item1").on("click", function() {
        util.href($(this).data("url"));
    })
    $(".top-nav .item2").on("click", function() {

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