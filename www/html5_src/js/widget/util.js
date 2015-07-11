define(function(require, exports) {
    function app(option, callback) {
        window.WebViewJavascriptBridge.send(option, callback);
    }
    function push(url) {
        var opts = {
            action: 'b_push',
            data: {"url": url}
        }
        app(opts, null);
    }
    function toast(msg, callback) {
        var opts = {
            action: 'b_toast_alert',
            data: {
                'message' : msg,
                'disappear_delay' : 1500
            }
        }
        app(opts, callback);
    }
    function appAuth(callback) {
        var opts = {
            action: 'b_require_auth',
            data: {
            }
        }
        app(opts, callback);
    }

    function appLocation(callback) {
        var opts = {
            action : "b_get_address",
            data : {
                "title" : "附近地点"
            }
        }
        app(opts, callback);
    }

    /*var appFn = {
        app : function (option, callback) {
            WebViewJavascriptBridge.send(json, callback);
        },
        push : function(_url) {
            var opts = {
                action: 'b_push',
                data: {url: _url}
            }
            this.app(opts, null);
        },
        toast : function(msg) {
            var opts = {
                action: 'b_toast_alert',
                data: {
                    'message' : msg,
                    'disappear_delay' : 1500
                }
            }
            this.app(opts, null);
        }
    }*/

    //跳转、兼容app和web页面
    function href(_url) {
        _url = miduoduo.basePath.base + _url ;
        if (!miduoduo.os.mddApp) {
            window.location.href = _url;
        } else {
            push(_url);
        }
    }

    //toast
    function showTips(msg, callback) {
        if (!miduoduo.os.mddApp) {
            alert(msg);
            callback();
        } else {
            toast("app:" + msg, callback);
        }
    }

    //注册、登陆
    function auth() {
        appAuth(function(data) {
            alert("hi:" + data);
            window.location.reload(); //登陆成功直接重新加载页面
        });
    }


    //设置地址
    function setAddress(callback) {
        appLocation(callback);
    }

    //设置confirm
    function cf(_opt, callback) {
       var opt =  {
            action: 'b_alert',
            data : {
                'disappear_delay' : -1,
                'title': _opt.title,
                'message': _opt.message,
                'operation' : {
                    'cancel' : '取消',
                    'ok' : '确定'
                }
            }
       }
       app(opt, callback);
    }

    //撤销页面
    function pop() {
        app({ action: 'b_pop', data : {}}, null);
    }

    //日期格式化输出
    Date.prototype.Format = function (fmt) { //author: meizz
        var o = {
            "M+": this.getMonth() + 1, //月份
            "d+": this.getDate(), //日
            "h+": this.getHours(), //小时
            "m+": this.getMinutes(), //分
            "s+": this.getSeconds(), //秒
            "q+": Math.floor((this.getMonth() + 3) / 3), //季度
            "S": this.getMilliseconds() //毫秒
        };
        if (/(y+)/.test(fmt)) fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
        for (var k in o)
            if (new RegExp("(" + k + ")").test(fmt)) fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
        return fmt;
    }

    exports.href = href;
    exports.showTips = showTips;
    exports.auth = auth;
    exports.setAddress = setAddress;
    exports.cf = cf;
    exports.pop = pop;
});