define(function(require, exports) {
    require("zepto");
    $.get = function(/* url, data, success, dataType */){
        var options = parseArguments.apply(null, arguments);
        options.error = handleError;
        return $.ajax(options)
    }

    $.post = function(/* url, data, success, dataType */){
        var options = parseArguments.apply(null, arguments)
        options.type = 'POST';
        options.error = handleError;
        return $.ajax(options)
    }

    $.put = function(/* url, data, success, dataType */){
        var options = parseArguments.apply(null, arguments);
        options.type = 'PUT';
        options.error = handleError;
        return $.ajax(options);
    }

    $.delete = function(/* url, data, success, dataType */){
        var options = parseArguments.apply(null, arguments);
        options.type = 'DELETE';
        options.error = handleError;
        return $.ajax(options);
    }

    var initGetReqNum = 0;

    $.pageInitGet = function(/* url, data, success, dataType */){
        //显示遮罩
        //...
        initGetReqNum += 1;
        var options = parseArguments.apply(null, arguments);
        var callback = options.success;
        options.success = function() {initGetReqCallbakcAspect(callback)}
        options.error = handleError;
        return $.ajax(options)
    }

    function initGetReqCallbakcAspect(cb) {
        initGetReqNum--;
        cb();
        if (initGetReqNum == 0) {
            //去除遮罩
        }
    }

    function handleError(res) {
        //验证失败
        if (res.status == 422) {
            var tipsArr = JSON.parse(res.response);
            var tipsStr = "";
            tipsArr.forEach(function(e) {
                tipsStr += e.message + "\n";
            });
            if (window.WebViewJavascriptBridge) {
                var opts = {
                    action: 'b_toast_alert',
                    data: {
                        'message' : tipsStr,
                        'disappear_delay' : 2000
                    }
                }
                window.WebViewJavascriptBridge.send(opts, null);
            } else {
                alert(tipsStr);
            }
        }
        if (res.status == 401) {
            if (window.WebViewJavascriptBridge) {
                WebViewJavascriptBridge.send({"action" : "b_require_auth", "data" : {}}, function(data){location.reload()});
            }
        }
        console.log(arguments);
       alert("访问异常：" + res.status + " " + res.statusText);
    }

    function parseArguments(url, data, success, dataType) {
        if ($.isFunction(data)) dataType = success, success = data, data = undefined
        if (!$.isFunction(success)) dataType = success, success = undefined
        return {
            url: url
            , data: data
            , success: success
            , dataType: dataType
        }
    }
});