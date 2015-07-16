miduoduo 协议
=====================

##js bridge的url
```
miduoduo://jsbridge.action?query=
```



#Js Bridge

我们Js Bridge的实现是基于开源[JsBridge](https://github.com/lzyzsd/JsBridge)

js调用native 方法原理
    * 在webview中，js通过添加iframe 节点，在ios/android可以捕获对应的事件，然后进行处理。


* 请求认证
```
    {
        action: 'b_require_auth',
        data: {
            'message': '请先登陆'
            'url' : view/x.html //登录后跳转
            }
    }

   
    Return :
    {
        action: 'b_require_auth',
        result: {
        "id": 4,
        "username": "18661775819",
        "access_token": "I-rakchs-AQnW9YiwAl7uwsLUsIrxT7p_1435949771"
      }

    附：
         在defaultHandler 接收返回数据
        如果未登陆，不返回任何东西，或返回access_token为null
```

* 刷新页面
```
    {
        action: 'b_refresh_all',
        data: { }
        
        附：
            接收到事件，会调用 js MDD.reload() 函数，html 在该接口自己刷新 
    }
```

* 提示框
```
    {
        action: 'b_alert',
        data = {
            'disappear_delay': -1, //整数，显示n毫秒后消失
            'title': '升级提示',
            'message': '米多多兼职',
            'operation' => [
                'cancel'=>'取消',
                'ok'=>'确定'
             ]
        }
    }
    Return:
    {
        action: 'b_alert',
        result: {
            value: 0 // operation的index
            },
        }
    WebViewJavascriptBridge.send(json, function (result) {
        alert('action: ' + result.action + ' -- result: ' + result.result)
    });
}
```

* Toast alert
```
    {
        action: 'b_toast_alert',
        data: {
            'message': '恭喜你登陆成功',
            'disappear_delay': n, //显示n毫秒后消失
            }
        }
    Return:
        No return data

    WebViewJavascriptBridge.send(json, function (result) {
        alert('action: ' + result.action + ' -- result: ' + result.result)
    });
```

* push页面
```
    {
        action: 'b_push',
        data = {
            'has_nav': true,
            'has_tab': false,
            'title': 'push 新页面',
            'left_action': null, // null可以取消任何显示
            'right_action': {title: '消息' ,action: {'action':action,'data' : data}],
            'url':'http://192.168.1.217/NewPage.html'
        }
    }
    Return:
        No return;
    var json = {'action':action,'data' : data}
    WebViewJavascriptBridge.send(json, function (result) {
        alert(' 返回 。。。。。');
    });
}
```

* pop页面
```
    {
        action: 'b_pop',
        data: {
            'back_refresh':true // 返回刷新上一个页面
            'quit_login': true //退出登陆
            //  简历页 url .....XXX.html?login=1
        },
    }
    Return:
        No return;
    var json = {'action':action,'data' : data}
    WebViewJavascriptBridge.send(json, function (result) {
        alert(' 返回 。。。。。');
    });
}
```

* 获取地址
```
    {
        action: 'b_get_address',
        data: {
            'title': '附近地点',
            address: {
               name: 地址名称,
               address: 具体地址,
               city: 城市,
               latitude: ,
               longitude: ,
            }
        }
    }
    Return:
    {
        action: 'b_get_address',
        result: {
            name: 地址名称,
            address: 具体地址,
            city: 城市,
            latitude: ,
            longitude: ,
            }
        }
```

* 获取Location
```
    {
        action: 'b_get_current_location',
        data: { // data可以为空，
            'title': ,
            'address': ,
            latitude: ,
            longitude: ,
        },
    }
    Return:
    {
        action: 'b_get_current_location',
        result = {
            'title': ,
            'address': ,
            latitude: ,
            longitude: ,
            },
    }
```


* 加载中/加载完毕
```
    {
        action: 'b_start_processing/b_stop_processing',
        data: {
            message: '加载中',
            }
        }
    Return:
        No return;
```

* 连接JSBridge 与处理 app 主动事件消息
```
document.addEventListener('WebViewJavascriptBridgeReady', function() {
     WebViewJavascriptBridge.defaultHandler(handle_action)
    }, false);


function handle_action(data, responseCallback) {
    data = {
            action: 'q_before_quit',
            data: {}
            }
    return = {
        action: 'q_before_quit',
        result: {
            value: true,
            message: '一般只用于不能退出提示',
            }
        }
    responseCallback(return);
});
```


###access_token 与 user 信息传递
* 在app打开webview，并载入url时会在url后靠 GET 传参的方式传递 access_token/user_id/username(phonenum) 
```
/v1/view/index.html?access_token=*the_access_token*&user_id=user_id&username=18661775819
```
* webview加载后，认证成功jsBridge回调
```
function handle_action(data, responseCallback) {
    data = {
            action: 'q_authed',
            data: {
                access_token: access_token,
                user_id: user_id, 
                username: username,
                }
            }
    return = {
        action: 'q_authed',
        result: {
            value: true,
            }
        }
    responseCallback(return);
});
```
