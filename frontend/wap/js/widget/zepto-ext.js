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
        $(".init-shade").show();
        initGetReqNum += 1;
        var options = parseArguments.apply(null, arguments);
        var callback = options.success;
        options.success = function(data) {initGetReqCallbakcAspect(data, callback)}
        options.error = handleError;
        return $.ajax(options)
    }

    function initGetReqCallbakcAspect(data, cb) {
        initGetReqNum--;
        cb(data);
        if (initGetReqNum == 0) {
            //去除遮罩
            $(".init-shade").hide();
        }
    }

    function handleError(res) {
        //401跳转到登陆页面
        if (res.status == 401) {
            if (window.WebViewJavascriptBridge) {
                window.localStorage.userInfo = null;
                WebViewJavascriptBridge.send({"action" : "b_require_auth", "data" : {}}, function(data){location.reload()});
                $(".init-shade").hide();
            }
        }
       //alert("访问异常：" + res.status + " " + res.statusText);
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