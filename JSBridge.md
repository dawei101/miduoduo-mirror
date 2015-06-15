#Js Bridge

我们Js Bridge的实现是基于开源[JsBridge](https://github.com/lzyzsd/JsBridge)
原理为,在webview中，js通过添加iframe 节点，在ios/android可以捕获对应的事件，然后进行处理。

* 提示框
```
function alertView() {
    var action = '3';
    var data = { 'type':3,'title': '升级提示', 'message': '米多多兼职 。。。。', 'delay':2, 'cancel':' － 取消 －','ok':' － 确定 －'}
    
    var json = {'action':action, 'data' : data }
    WebViewJavascriptBridge.send(json, function (result) {
        alert('action: ' + result.action + ' -- result: ' + result.result)
    });
}
```

* ??
```
function hud() {
    var action = '3';
    var data = { 'type':5,'message': '恭喜你！ 登录 成功！', 'delay':3}
    
    var json = {'action':action, 'data' : data }
    WebViewJavascriptBridge.send(json, function (result) {
        alert('action: ' + result.action + ' -- result: ' + result.result)
    });
}
```

* 获取地址
```
function getAddress() {
    var action = 8;
    var data = {'title': '附近地点', 'city': '北京','latitude':39.927321,'longitude':116.434821}
    var json = {'action':action,'data' : data}
    WebViewJavascriptBridge.send(json, function (result) {
        alert('name: ' + result.name + 
            '\n address: ' + result.address  + 
            '\n city: ' + result.city + 
            '\n location: {' + result.latitude + ',' + result.longitude + '}')
    });
}
```

* push页面
```
function pushView() {
    var action = 5;
    var data = {'nvshow':1, 'title': 'push 新页面', 'url':'http://192.168.1.217/NewPage.html'}
    var json = {'action':action,'data' : data}
    WebViewJavascriptBridge.send(json, function (result) {
        alert(' 返回 。。。。。');
    });
}

function pushViewNo() {
    var action = 5;
    var data = {'nvshow':0, 'url':'http://192.168.1.217/NewPage.html'}
    var json = {'action':action,'data' : data}
    WebViewJavascriptBridge.send(json, function (result) {
        alert(' 返回 。。。。。');
    });
}

```

* 刷新
```
function refreshView() {
    var action = '3';
    var data = { 'type':2,'message': '刷新中 .....！'}
    
    var json = {'action':action, 'data' : data }
    WebViewJavascriptBridge.send(json, function (result) {
    });
    window.setTimeout(hiddenView,10000);
}
```

* ??
```
function hiddenView() {
    var action = '3';
    var data = { 'type':1}
    
    var json = {'action':action, 'data' : data }
    WebViewJavascriptBridge.send(json, function (result) {
    });
}
```

* 按钮事件
```
function onBkJsBridgeReady() {
    
    WebViewJavascriptBridge.defaultHandler(
        function(data,responseCallback) {
            if (data.action == 7) {
                var r=confirm("native 按下了返回键");
                if (r==true) {
                    responseCallback({'result': 1});
                } else {
                    responseCallback({'result': 0});
                }
            };
        });
};
```

* 连接JSBridge
```
if (window.WebViewJavascriptBridge) {
    onBkJsBridgeReady()
} else {
    document.addEventListener('WebViewJavascriptBridgeReady', function() {
        onBkJsBridgeReady()
    }, false)

```

