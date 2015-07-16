define(function(require,exports){function app(option,callback){window.WebViewJavascriptBridge.send(option,callback)}function push(url){var opts={action:"b_push",data:{url:url}};app(opts,null)}function toast(msg,callback){var opts={action:"b_toast_alert",data:{message:msg,disappear_delay:1500}};app(opts,callback)}function appAuth(url,callback){var opts={action:"b_require_auth",data:{url:url}};app(opts,callback)}function appReg(url){var opts={action:"b_require_reg",data:{url:url}};app(opts)}function appLocation(address,callback){var opts={action:"b_get_address",data:{address:address}};app(opts,callback)}function href(_url){_url=miduoduo.basePath.base+_url,miduoduo.os.mddApp?push(_url):window.location.href=_url}function showTips(msg,callback){miduoduo.os.mddApp?toast(msg,callback):(alert(msg),callback&&callback())}function auth(url){appAuth(url,function(data){})}function reg(url){appReg(url,function(data){})}function setAddress(address,callback){appLocation(address,callback)}function cf(_opt,callback){var opt={action:"b_alert",data:{disappear_delay:-1,title:_opt.title,message:_opt.message,operation:{cancel:"取消",ok:"确定"}}};app(opt,callback)}function pop(isBackRefresh){app({action:"b_pop",data:{back_refresh:isBackRefresh}},null)}function popLogin(isPopLogin){app({action:"b_pop",data:{quit_login:isPopLogin}},null)}Date.prototype.Format=function(fmt){var o={"M+":this.getMonth()+1,"d+":this.getDate(),"h+":this.getHours(),"m+":this.getMinutes(),"s+":this.getSeconds(),"q+":Math.floor((this.getMonth()+3)/3),S:this.getMilliseconds()};/(y+)/.test(fmt)&&(fmt=fmt.replace(RegExp.$1,(this.getFullYear()+"").substr(4-RegExp.$1.length)));for(var k in o)new RegExp("("+k+")").test(fmt)&&(fmt=fmt.replace(RegExp.$1,1==RegExp.$1.length?o[k]:("00"+o[k]).substr((""+o[k]).length)));return fmt},exports.href=href,exports.showTips=showTips,exports.auth=auth,exports.reg=reg,exports.setAddress=setAddress,exports.cf=cf,exports.pop=pop,exports.popLogin=popLogin});