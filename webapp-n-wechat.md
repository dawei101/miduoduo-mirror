#webapp 运行在微信中

* 获取设置
```
GET http://m.miduoduo.cn/wechat/env -> application/json
RETURN:
{
  "wx_config": {
    "nonceStr": "475044",
    "jsapi_ticket": "sM4AOVdWfPE4DxkXGEs8VHdv6jGhQ3KiG1RN2nY6tLck55NoezmR-2QPDWvlMCNERhRDk0UHU4AA7oHmKL5lnw",
    "timestamp": 1437599034,
    "signature": "9a36c91a3801ce2db6b71645593d7b73b55cfbdf",
    "debug": true,
    "appId": "wxf18755b4d95797ac"
  },
  "baidu_map_key": "GB9AZpYwfhnkMysnlzwSdRqq"
}


GET http://m.miduoduo.cn/wechat/env?callback=function_name -> application/javascript
RETURN:
function_name('{"wx_config":{"nonceStr":"475044","jsapi_ticket":"sM4AOVdWfPE4DxkXGEs8VHdv6jGhQ3KiG1RN2nY6tLck55NoezmR-2QPDWvlMCNERhRDk0UHU4AA7oHmKL5lnw","timestamp":1437599034,"signature":"9a36c91a3801ce2db6b71645593d7b73b55cfbdf","debug":true,"appId":"wxf18755b4d95797ac"},"baidu_map_key":"GB9AZpYwfhnkMysnlzwSdRqq"}')
 
```
