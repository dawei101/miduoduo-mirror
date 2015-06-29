define(function(require, exports, module) {
    require("zepto");
    require("widget/touchSlide");
    var tpl = require("widget/tpl-engine");

    //轮播
    var banners = [
        {url: "", imgSrc : miduoduo.config.picUrl + "/index/banner1.jpg"},
        {url: "", imgSrc : miduoduo.config.picUrl + "/index/banner2.jpg"}
    ]
    $("#bannerSlider").touchSlide();
    $(".imageSlide").html(tpl.parse("banner-slide-tpl", {"banners" : banners}));
});