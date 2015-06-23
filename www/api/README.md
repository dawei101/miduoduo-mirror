
#API
BASE_URL = 'http://api.miduoduo.cn'

##Login 
###通过验证码与手机登陆步骤
-1
    POST /v1/entry/vcode
        参数:    phonenum=手机号
    RETURN:
        { "result": true,
          "message": "验证码已发送" }
        OR:
        { "result": false,
          "message": 错误提示 }

-2
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
###通过手机号密码登陆
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

###注册
-1
    POST /v1/entry/vcode-for-signup
        参数:    phonenum=手机号
    RETURN:
        { "result": true,
          "message": "验证码已发送" }
        OR:
        { "result": false,
          "message": 错误提示 }

-2
    POST /v1/entry/signup

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
                "password": 密码(直接返回登陆的密码),
                "access_token": "S1AVJulRj22ZwzDAcLB4-zL2Y1kYMZt1_1434246288"
                }
        }

###修改密码
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
                * 待编写
            * http://api.test.chongdd.cn/v1/task?expand=service_type&filters=['service_type_id', '=', '10']
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
* 参见http协议

### rest api 举例
以任务列表(职位列表)为例，任务的model名为task
* 获取task
    * GET http://api.test.chongdd.cn/task
* 获取某服务类别的task
    GET http://api.test.chongdd.cn/task?filters=[["=", "service_type_id", 10]]


