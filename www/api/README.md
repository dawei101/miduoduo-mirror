
#API
BASE_URL = 'http://api.miduoduo.cn'

##Login 
###通过验证码与手机登陆步骤
-1
    POST /v1/auth/vcode
        参数:    phonenum=手机号
    RETURN:
        { "result": true,
          "message": "验证码已发送" }
        OR:
        { "result": false,
          "message": 错误提示 }

-2
    POST /v1/auth/vlogin

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
    POST /v1/auth/login

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
    POST /v1/auth/vcode-for-signup
        参数:    phonenum=手机号
    RETURN:
        { "result": true,
          "message": "验证码已发送" }
        OR:
        { "result": false,
          "message": 错误提示 }

-2
    POST /v1/auth/signup

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
    POST /v1/auth/set-password
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
-[Http Basic](https://zh.wikipedia.org/zh-sg/HTTP%E5%9F%BA%E6%9C%AC%E8%AE%A4%E8%AF%81)
-access_token
    在所有url后 + ?access_token=登陆成功返回的access_token

##使用api
api完全使用rest方式完成
###path规则
    基础的path
    /api_version/model_name(*注，不用复数格式)
    列表:
        GET /api_version/model_name

    详情
        GET /api_version/model_name/id

    创建
        POST /api_version/model_name
            post params = {}


