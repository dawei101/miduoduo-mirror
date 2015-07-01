define(function(require, exports, module) {
    require("zepto");
    require("widget/touchSlide");
    var tpl = require("widget/tpl-engine");
    var sLoad = require("widget/scroll-load");
    var api = require("widget/api");

    //轮播
    var banners = [
        {url: "", imgSrc : miduoduo.config.picUrl + "/index/banner1.jpg"},
        {url: "", imgSrc : miduoduo.config.picUrl + "/index/banner2.jpg"},
        {url: "", imgSrc : miduoduo.config.picUrl + "/index/banner1.jpg"},
        {url: "", imgSrc : miduoduo.config.picUrl + "/index/banner2.jpg"}

    ]
    $(".imageSlide").html(tpl.parse("banner-slide-tpl", {"banners" : banners}));
    $("#bannerSlider").touchSlide();

    //职位列表，滚动加载
    sLoad.startWatch(api.gen("task"), {"page" : 1, "per-page" : 30}, function(data) {
        $(".content").find(".pullUp").before(tpl.parse("job-list-tpl", {"jobs" : data.items}));
    });
});