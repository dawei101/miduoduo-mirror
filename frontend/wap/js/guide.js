define(function(require, exports, module) {
    require("zepto");
    require("widget/touchSlide");
    var tpl = require("widget/tpl-engine");
    var api = require("widget/api");

    //轮播
    var banners = [
        {url: "", imgSrc : miduoduo.basePath.picUrl + "/guide-1.jpg"},
        {url: "", imgSrc : miduoduo.basePath.picUrl + "/guide-2.jpg"},
        {url: "", imgSrc : miduoduo.basePath.picUrl + "/guide-3.jpg"},
        {url: "", imgSrc : miduoduo.basePath.picUrl + "/guide-4.jpg"}

    ]
    $(".imageSlide").html(tpl.parse("banner-slide-tpl", {"banners" : banners}));
    $("#bannerSlider").touchSlide();
});