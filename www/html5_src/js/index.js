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
        var action = 'b_push';
        var data = {'has_nav':true ,'has_tab':false , 'title': 'push 新页面', 'url':'http://192.168.1.217/NewPage.html',
            'left_action': {'title': '消息' ,'action': {'action':'left_action','data' : 'left 按钮点击'} },
            'right_action': {'title': '消息' ,'action': {'action':'right_action','data' : '右边按钮点击'} }}

        var json = {'action':action,'data' : data}
        window.WebViewJavascriptBridge.send(json, function (result) {
            alert(' 返回 。。。。。');
        });
    })

    //职位列表，滚动加载
    sLoad.startWatch(api.gen("task"), {"page" : 1, "per-page" : 30}, function(data) {
        $(".content").find(".pullUp").before(tpl.parse("job-list-tpl", {"jobs" : data.items}));
    });

    $(".content").on("click", "a", function(e) {
        e.preventDefault();
        util.href($(this).attr("href"));
    })
});