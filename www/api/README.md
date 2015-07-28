
#API
BASE_URL = 'http://api.miduoduo.cn'

##Login 
###通过验证码与手机登陆步骤
- 1
```
    POST /v1/entry/vcode
        参数:    phonenum=手机号
    RETURN:
        { "result": true,
          "message": "验证码已发送" }
        OR:
        { "result": false,
          "message": 错误提示 }
```
- 2
```
    POST /v1/entry/vlogin

        参数:   phonenum=手机号
                code=验证码

    return:
        { "success": false,
            "message": 错误提示 }
        OR
        { "success": true,
            "message": "登陆成功",
            "result": {
                "username": "18661775819",
                "password": 密码(验证码登陆会返回空),
                "access_token": "S1AVJulRj22ZwzDAcLB4-zL2Y1kYMZt1_1434246288"
                }
        }
```
###通过手机号密码登陆
```
    POST /v1/entry/login

        参数:   phonenum=手机号
                password=密码

    return:
        { "success": false,
            "message": 错误提示 }
        OR
        { "success": true,
            "message": "登陆成功",
            "result": {
                "username": "18661775819",
                "password": 密码(直接返回登陆的密码),
                "access_token": "S1AVJulRj22ZwzDAcLB4-zL2Y1kYMZt1_1434246288"
                }
        }
```
###注册
- 1
```
    POST /v1/entry/vcode-for-signup
        参数:    phonenum=手机号
    RETURN:
        { "result": true,
          "message": "验证码已发送" }
        OR:
        { "result": false,
          "message": 错误提示 }
```
- 2
```
    POST /v1/entry/signup

        参数:   phonenum=手机号
                code=验证码
                password=选填

    return:
        { "success": false,
            "message": 错误提示 }
        OR
        { "success": true,
            "message": "登陆成功",
            "result": {
                "username": "18661775819",
                "password": 密码(直接返回登陆的密码),
                "access_token": "S1AVJulRj22ZwzDAcLB4-zL2Y1kYMZt1_1434246288"
                }
        }
```
###绑定第三方账号
```
    POST /v1/user/bind-third-party-account
        参数:
            platform=, //wechat等
            params={
                openid: ,
                ....
            }, //  转化为post参数 即: &params[openid]=openid&params[nickname]=nickname&...
    return:
        { "success": false,
            "message": 错误提示 }
        OR
        { "success": true,
            "message": 绑定结果,
        }
```

###第三方账号登陆
```
    POST /v1/entry/t-login
        参数:
            platform=, //wechat等
            params={
                openid: ,
                ....
            }, //  转化为post参数 即: &params[openid]=openid&params[nickname]=nickname&...
    return:
        { "success": false,
            "message": 错误提示 }
        OR
        { "success": true,
            "message": "登陆成功",
            "result": {
                "username": "18661775819",
                "password": 密码(直接返回登陆的密码),
                "access_token": "S1AVJulRj22ZwzDAcLB4-zL2Y1kYMZt1_1434246288"
                "resume": {
                    ...
                },
                }
        }
```

###修改密码
```
    POST /v1/user/set-password
    auth required
        参数:   password=修改的密码
                password2=重复确认密码
    return:
        { "success": false,
            "message": 错误提示 }
        OR
        { "success": true,
            "message": 修改成功,
            "result": {
                "username": "18661775819",
                "password": 密码(直接返回登陆的密码),
                "access_token": "S1AVJulRj22ZwzDAcLB4-zL2Y1kYMZt1_1434246288"
                }
        }
    备注：* 重新设置密码后，之前的access_token将失效
```

##request请求 标识认证信息

我们有两种方式标识出登录后的认证信息
- [Http Basic](https://zh.wikipedia.org/zh-sg/HTTP%E5%9F%BA%E6%9C%AC%E8%AE%A4%E8%AF%81)
- access_token
    * 在所有url后 + ?access_token=登陆成功返回的access_token

##使用api
###api遵循rest api协议

* Path构成
    * /version/model(/:id)
* 请求
    * 分页 见列表内 "_link"
    * 列表 
        * GET /version/model?page=1&per-page=2&expand=company,service_type (*注，不用复数格式)
            * expand 为连表查询的关系字段
            * page 为要获取的页, default=1
            * per-page 为每页数据条数, default=20
            * filters 为筛选条件, 语法如下
                * filters 为数组
                * filters 格式 [[operation, field_name, value], ...]
                * filters 中允许的 operation如下
                    * "=",
                    * "!=",
                    * "<>",
                    * ">=",
                    * "<=",
                    * "LIKE",
                    * "ILIKE",
                    * "IN",
                    * "NOT IN",
            * orders 为排序条件, 语法如下:
                * [order_rule1, order_rule2, ...]
                * order 规则如下：
                ```
                    -id:        按id降序排列
                    id:         按id升序排列
                    -task.id:   按task的id 降序排序
                ```
            * http://api.test.chongdd.cn/v1/task?expand=service_type&filters=[['service_type_id', '=', '10']]
        * 返回格式:
        ```
    {
        "items": [
                {}, {}, {}, {}, {}
        ],
        "_links": {
            "self": {
              "href": "baseurl/v1/task?page=1&per-page=100"
            },
            "next": {
              "href": "baseurl/v1/task?page=2&per-page=100"
            },
            "last": {
              "href": "baseurl/v1/task?page=2&per-page=100"
            }
        },
        "_meta": {
            "totalCount": 104,
            "pageCount": 2,
            "currentPage": 1,
            "perPage": 100
        }
    }
        ```
    * 详情
        * GET /version/model/id
    * 创建
        * POST /version/model
        * post params = {}
        * 返回值
        ```
        ```
    * 删除
        * DELETE /version/model/id

### 执行失败全局返回说明
* http请求返回的status,[参见http协议](https://zh.wikipedia.org/wiki/HTTP%E7%8A%B6%E6%80%81%E7%A0%81)

具体api
=============================

### 区域

* 获取城市列表
    * GET /version/district?filters=[["=", "level", "city"]]

* 获取城市的区域
    * GET /version/district?filters=[["=", "parent_id", city_id]]
* 区域
```
    {
      "id": 4,
      "parent_id": 3,
      "name": "东城区",
      "level": "district",
      "citycode": "010",
      "postcode": "110101",
      "center": "116.418757,39.917544",
      "full_name": "北京市-北京市市辖区-东城区",
      "disabled": 0
    },
```

### 任务类型
* 任务类型列表
    * GET /version/service-type
* 类型详情(几乎无用)
    * GET /version/service-type/id

### 任务（职位）
* 任务列表
    * GET /version/task?expand=company,service_type,city,district,user,addresses&date_range=(weekend_only|current_week|next_week)
    * date_range
        * weekend_only = 查询周末（周六、周日）任务（一个月内的周末任务）
        * current_week = 查询本周任务
        * next_week = 下周任务

* 任务详情
    * GET /version/task/gid

### 附近任务
    *GET /version/task-address/nearby?lat=39.995723&lng=116.423313&distance=5000&service_id&expand=task,company,service_type&date_range=


###任务报名
* 获取已报名的任务列表 
    * GET /version/task-applicant?expand=task
* 报名某任务
    * POST /version/task-applicant
    * params: user_id, task_id
* 取消报名某任务
    * DELETE /version/task-applicant/task_id
* 获取某任务报名情况
    * GET /version/task-applicant/task_id
    *  如果未报名 return 404

###简历 Resume

* 获取自己简历(使用须取列表中第一个)
    * GET /version/resume?expand=service_types,free_times,home_address,workplace_address
* 获取自己的简历
    * GET /version/resume/user_id?expand=service_types,free_times,home_address,workplace_address
* 更新自己简历
    * PUT /version/resume/user_id
* 创建自己简历
    * POST /vesion/resume

###时间表 Freetime(获取简历时可直接获取)

* 获取自己一周的时间表
    * GET /version/freetime
* 获取某天的时间表
    * GET /version/freetime/day_of_week
    * day_of_week ＝ range(1-7)
* 更新某天的时间表
    * PUT /version/freetime/day_of_week
* 更改所有时间为free
    * POST /version/freetime/free-all

###设置我可做的服务

* 获取可做的服务列表(获取简历时直接获取)
    * GET /version/user-service-type
* 添加可做服务
    * POST /version/user-service-type
        * params: {service_type_id: 10}
* 删除可做服务
    * DELETE /version/user-service-type/service_type_id


###Address 地址
* 获取自己的地址列表
    * GET /version/address
* 查看某地址
    * GET /version/address/id
* 添加新地址
    * POST /version/address
    * params: province,city,district,address,lat,lng
* 修改已有地址
    * PUT /version/address/id
    * params: province,city,district,address,lat,lng
* 删除已有地址
    * DELETE /version/address/id

###收藏

* 获取收藏的任务列表 
    * GET /version/task-collection?expand=task
* 收藏某任务
    * PUT /version/task-collection
    * params: user_id, task_id
* 取消收藏某任务
    * DELETE /version/task-collection/task_id
* 获取收藏某任务的细节
    * GET /version/task-collection/task_id
    * 如果未收藏return 404

### Message 普通消息
* 获取消息列表
    * GET /version/message
* 获取消息详情(用不到)
    * GET /version/message/id
* 标记信息为read
    * PUT /version/message/id
      params = 随便
* 标记所有信息为read
    * POST /version/message/update-all

### System Message 系统消息
* 获取消息列表
    * GET /version/sys-message?expand=read_flag
* 获取消息详情(用不到)
    * GET /version/sys-message/id
* 标记信息为read
    * PUT /version/sys-message/id
      params = 随便
* 标记所有信息为read
    * POST /version/sys-message/update-all

### 投诉举报
* 获取我举报过的任务列表
    * GET /version/complain
* 获取消息详情(用不到)
    * GET /version/complain/task_id
* 举报
    * POST /version/complain
      params = {title: ,content:, task_id:, phonenum:, }

### 联系我们
    * POST /version/contact-us
      params = {title: optional,content: required, phonenum: required, }

## 关于性能上的优化
    * TODO

## 关于跨域
[Http access control - CORS](https://en.wikipedia.org/wiki/Cross-origin_resource_sharing)
原理：
* 浏览器发送http request 带着 origin
* 服务器http response 带着 Access-Control-Allow-Origin
    * 例 Access-Control-Allow-Origin: http://m.miduoduo.cn
欲知详情请深挖[Wiki](https://en.wikipedia.org/wiki/Cross-origin_resource_sharing)
