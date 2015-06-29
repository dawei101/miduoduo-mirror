define(function(require, exports, module) {
    require("zepto");
    require("widget/touchSlide");
    var tpl = require("widget/tpl-engine");
    console.log(tpl.parse);

    $("#bannerSlider").touchSlide({});

    return;
    require("angular");

    var indexApp = angular.module('indexApp', []);
    indexApp.controller('indexCtrl', ['$scope',
        function($scope) {
           console.log($scope);
        }]);

    indexApp.directive("imgslider", function() {
        return {
            restrict : "E",
            replace : "true",
            transclude : "true",
            template : "<div ng-transclude></div>",
            link : function(scope, element, attrs) {
                window.cc = element;
                function touchSlide(el, opts) {
                    var self = this;
                    console.log(self.defaults);
                    opts = angular.extend({}, self.defaults, opts);
                    self.wrap = el;
                    self.index = 0;
                    self.ul = self.wrap.find(opts.ul);
                    self.li = self.ul.find(opts.li);
                    self.len = self.li.length;
                    self.ul.css("width", (self.len + (opts.isLoop ? 2 : 0))*100 + "%");
                    self.li.css("width", (100/(self.len + (opts.isLoop ? 2 : 0))) + "%" );
                    self.liWidth = self.li[0].offsetWidth;
                    self.numBox = self.wrap.find(opts.numBox);
                    self.isLoop = opts.isLoop;
                    self.isAuto = opts.isAuto;
                    self.lazyLoad = opts.lazyLoad;
                    self.imgSrc = opts.imgSrc;
                    self.cur = opts.cur;
                    self.speed = opts.speed;
                    self.autoTime = opts.autoTime;
                    self.timer = null;
                    //执行
                    self.init();;
                }

                touchSlide.prototype = {
                    init : function() {
                        var self = this;
                        self.config();
                       self.autoPlay();
                        //self.bind();
                    },
                    /*配置*/
                    config: function() {
                        var self = this;
                        for (var m = 0; m < self.len; m++) {
                            self.numBox.append("<b>" + (m + 1) + "/" + self.len + "</b>");
                        }
                        self.numBoxB = self.numBox.children();
                        self.numBoxB.eq(0).addClass(self.cur);
                        /*添加覆盖loading层*/
                        if (self.lazyLoad) {
                            for (var n = 0; n < self.len; n++) {
                                self.li.eq(n).append("<div class='loading-cover'></div>");
                            }
                        }
                        if (self.isLoop) {
                            //lazyLoad的时候第一张图片加载完成后再clone
                            if (self.lazyLoad) {
                                self.loadImg(0,
                                    function() {
                                        self.ul.append(self.li.eq(0).clone());
                                        //lazyLoad的时候最后一张图片加载完成后再clone
                                        self.loadImg(self.len - 1,
                                            function() {
                                                self.ul.append(self.li.eq(self.len - 1).clone());
                                                self.ul.children().eq(self.len + 1).css({
                                                    "position": "relative",
                                                    "left": -self.liWidth * (self.len + 2)
                                                });
                                            });
                                    });
                            }
                            //否则
                            else {
                                self.ul.append(self.li.eq(0).clone());
                                self.ul.append(self.li.eq(self.len - 1).clone());
                                self.ul.children().eq(self.len + 1).css({
                                    "position": "relative",
                                    "left": -self.liWidth * (self.len + 2) +"px"
                                });

                            }
                        } else {
                            self.lazyLoad && self.loadImg(0);
                        }
                    },
                    /*移动*/
                    move: function() {
                        var self = this;
                        if (arguments[0] == 0) {
                            //不循环的时候
                            if (!self.isLoop) {
                                if (self.index < self.len - 1) {
                                    self.index++;
                                } else {
                                    clearInterval(self.timer);
                                }
                            }
                            //循环的时候
                            else {
                                self.index++;
                            }
                        } else if (arguments[0] == 1) {
                            if (!self.isLoop && self.index > 0) {
                                self.index--;
                            } else if (self.isLoop) {
                                self.index--;
                            }
                        }
                        console.log("speed", self.speed);
                        $(self.ul[0]).animate({
                                "left": -self.liWidth * self.index + "px"
                            },
                            self.speed,
                            "ease",
                            function() {
                                self.lazyLoad && self.loadImg(self.index);
                                if (self.index > self.len - 1) {
                                    self.ul.css("left", 0);
                                    self.index = 0;
                                } else if (self.index < 0) {
                                    self.ul.css("left", -self.liWidth * (self.len - 1) + "px");
                                    self.index = self.len - 1;
                                }
                            });
                        self.numBoxB.removeClass(self.cur).eq(self.index).addClass(self.cur);
                        if (self.isLoop && self.index == self.len) {
                            self.numBoxB.removeClass(self.cur).eq(0).addClass(self.cur);
                        }
                    },
                    /*加载图片函数*/
                    loadImg: function(index, callback) {
                        var self = this;
                        if (self.lazyLoad) {
                            var o = self.li.eq(index).find("img");
                            //图片都加载完成后不再执行下面的方法
                            if (o.attr(self.imgSrc)) {
                                var img = new Image();
                                img.src = o.attr(self.imgSrc);
                                img.onload = function() {
                                    o.attr("src", img.src);
                                    o.removeAttr(self.imgSrc);
                                    self.li.eq(index).find(".loading-cover").remove();
                                    callback && typeof callback == "function" && callback();
                                }
                            }
                        }
                    },
                    /*自动*/
                    autoPlay: function() {
                        var self = this;
                        clearInterval(self.timer);
                        if (self.isAuto) {
                            self.timer = setInterval(function() {
                                    self.move(0);
                                },
                                self.autoTime);
                        }
                    },
                    /*touch事件*/
                    bind: function() {
                        var self = this;
                        var startX, startY, ulOffset, spirit = null;

                        function touchStart(event) {
                            clearInterval(self.timer);
                            spirit = null;
                            if (!event.touches.length) return;
                            var touch = event.touches[0];
                            startX = touch.pageX;
                            startY = touch.pageY;
                            ulOffset = parseInt(self.ul.css("left"));
                        }

                        function touchMove(event) {
                            if (!event.touches.length) return;
                            var touch = event.touches[0],
                                x = touch.pageX - startX,
                                y = touch.pageY - startY;
                            //阻止网页默认动作（即网页滑动）
                            event.preventDefault();
                            //这里是为了手指一定是横向滑动的,原理是计算X位置的偏移要比Y的偏移大
                            if (Math.abs(x) > Math.abs(y)) {
                                //向左滑动
                                if (x < 0) {
                                    spirit = 0;
                                    self.ul.css("left", ulOffset - Math.abs(x) + "px");
                                }
                                //向右滑动
                                else {
                                    spirit = 1;
                                    self.ul.css("left", ulOffset + Math.abs(x) + "px");
                                }
                            }
                        }

                        function touchEnd(event) {
                            spirit == 0 && self.move(0);
                            spirit == 1 && self.move(1);
                            self.autoPlay();
                        }
                        //手机是高级浏览器，不必做addEventListener的兼容
                        self.wrap[0].addEventListener("touchstart", touchStart, false);
                        self.wrap[0].addEventListener("touchmove", touchMove, false);
                        self.wrap[0].addEventListener("touchend", touchEnd, false);
                    },
                    defaults : {
                        //列表框的标签
                        ul: "ul",
                        //列表标签
                        li: "li",
                        //图片序列号按钮BOX
                        numBox: ".num",
                        //数字按钮焦点样式
                        cur: "cur",
                        //是否需要循环轮播
                        isLoop: true,
                        //是否自动播放
                        isAuto: true,
                        //是否启用图片延迟加载，提高网站初次载入的速度
                        lazyLoad: false,
                        //启用图片延迟加载时，真正图片存贮的属性名称
                        imgSrc: "data-src",
                        //效果时间
                        speed: 300,
                        //效果间隔时间
                        autoTime: 2000
                    }
                }
                var s = new touchSlide(element, {});
            }
        }
    })

});