define(function(require,exports){function initGetReqCallbakcAspect(data,cb){initGetReqNum--,cb(data),0==initGetReqNum&&$(".init-shade").hide()}function handleError(res){401==res.status&&window.WebViewJavascriptBridge&&(window.localStorage.userInfo=null,WebViewJavascriptBridge.send({action:"b_require_auth",data:{}},function(data){location.reload()}),$(".init-shade").hide()),alert("api访问异常："+res.status+" "+res.statusText)}function parseArguments(url,data,success,dataType){return $.isFunction(data)&&(dataType=success,success=data,data=void 0),$.isFunction(success)||(dataType=success,success=void 0),{url:url,data:data,success:success,dataType:dataType}}require("zepto"),require("../widget/fastclick"),$.get=function(){var options=parseArguments.apply(null,arguments);return options.error=handleError,$.ajax(options)},$.post=function(){var options=parseArguments.apply(null,arguments);return options.type="POST",options.error=handleError,$.ajax(options)},$.put=function(){var options=parseArguments.apply(null,arguments);return options.type="PUT",options.error=handleError,$.ajax(options)},$["delete"]=function(){var options=parseArguments.apply(null,arguments);return options.type="DELETE",options.error=handleError,$.ajax(options)};var initGetReqNum=0;$.pageInitGet=function(){$(".init-shade").show(),initGetReqNum+=1;var options=parseArguments.apply(null,arguments),callback=options.success;return options.success=function(data){initGetReqCallbakcAspect(data,callback)},options.error=handleError,$.ajax(options)}});