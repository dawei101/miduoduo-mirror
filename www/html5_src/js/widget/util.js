define(function(require, exports) {
    function forward(url) {
        if (WebViewJavascriptBridge) {

        }
    }

    function app(option, callback) {
        WebViewJavascriptBridge.send(json, callback);
    }


    function href(_url) {
        if (!miduoduo.os.mddApp) {
            location.href = url;
        } else {
            var opts = {
                action: 'b_push',
                data: {url: _url}
            }
            app(opts, null);
        }

    }

});