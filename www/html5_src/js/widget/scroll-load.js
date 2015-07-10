define(function (require, exports) {
    var scroll = require('./window-scroll');


    var pullUp = $('.pullUp')
        , win = $(window)
        , win_h = win.height()
        , idDataLoad = false
        , pullUp_top
        , url
        , urlData
        , callback

    var watchScroll = function () {
        idDataLoad = false;
        //pullUp.attr('status', 'loading');
        pullUp.show();
        $.get(url, urlData, function (res) {
            //pullUp.attr('status', 'tap');
            pullUp.hide();
            urlData.page++;
            idDataLoad = true;
            callback(res);
        }, 'json')
    }

    var scrollPoster = function (isscroll) {
        function scrollPoster(pos, isDown) { //pos和isDown是scroll-load回调时传递的位置和方向参数
            if (isDown) {
                pullUp_top = pullUp[0].getBoundingClientRect().top;
                if (pullUp_top - 100 <= win_h && idDataLoad) {
                    watchScroll();
                }
            }
        }
        scroll.bind(scrollPoster, 'scrollPoster')
    }
    /**
     * 入口函数，开始监控页面滚动，当滚动到最底部时，加载数据
     * @param api   url
     * @param opts url参数
     * @param callback 回掉函数
     */
    var startWatch = function (_url, urlParam, _callback, _pullUp) {
        url = _url;
        urlData = urlParam;
        callback = _callback;
        watchScroll();
        scrollPoster();
    }

    exports.startWatch = startWatch;
});
