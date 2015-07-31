miduoduo 协议
=====================

##js bridge的url
```
miduoduo 协议：
1、跳转： mdd:// 跳转协议
2、window.MDD 获取交互对象，采用 JS 直接通过MDD 对象调用 native 方法
```


回调函数：
在 交互时，回调函数以函数名字符串方式 传递，在双方需要回调时，通过反射方式，将字符串函数名进行调用
回调函数只有一个 String 类型参数

如
function CallBack(str) {
    .....
}

在传递时，'CallBack'

以下 callback 为该类型

* log 调试信息打印
```
    window.MDD.log(message)

```

* 请求认证
```
    window.MDD.auth()

```

* 刷新页面
```
    window.MDD.refreshAll()
        
    附：
        接收到事件，会调用 js MDD.reload() 函数，html 在该接口自己刷新 
```

* 确认框
```
    /**
    message: 要显示的内容
    callback：提示选择后的回调，回调为 JS 函数名，用字符串方式传递
    */
    window.MDD.confirm(message,callback)

    附：
        callback：回调函数

```

* 提示框
```
    window.MDD.alert(message)

```

* push页面
```
    mdd://XXXX.html
```

* pop页面
```
    window.MDD.pop()
```

* 获取地址
```
    window.MDD.address(callback)

    callback(address)  address: json 字符串
```

* 获取access_token
```
    var token = window.MDD.accessToken()

    token: 字符串
```

* 获取Location
```
    window.MDD.location(callback)

    callback：回调函数名
```

* 加载中
```
    window.MDD.startLoading(message)
    
    message: '加载中' 提示内容
```

* 加载完毕
```
    window.MDD.stopLoading()

```

* 返回事件
```
    javascript:back()

    html: 收到返回事件，可以自行处理，如果需要返回，调用 window.MDD.pop()
```


