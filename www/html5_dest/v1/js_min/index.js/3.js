define(function(require,exports,module){require("zepto"),require("widget/touchSlide");var tpl=require("widget/tpl-engine"),sLoad=require("widget/scroll-load"),api=require("widget/api"),banners=[{url:"",imgSrc:miduoduo.config.picUrl+"/index/banner1.jpg"},{url:"",imgSrc:miduoduo.config.picUrl+"/index/banner2.jpg"},{url:"",imgSrc:miduoduo.config.picUrl+"/index/banner1.jpg"},{url:"",imgSrc:miduoduo.config.picUrl+"/index/banner2.jpg"}];$(".imageSlide").html(tpl.parse("banner-slide-tpl",{banners:banners})),$("#bannerSlider").touchSlide(),sLoad.startWatch(api.gen("task"),{page:1,"per-page":30},function(data){$(".content").find(".pullUp").before(tpl.parse("job-list-tpl",{jobs:data.items}))})});