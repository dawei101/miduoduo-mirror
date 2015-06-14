
#API
BASE_URL = 'http://api.miduoduo.cn'

##Login 
通过验证码与手机登陆步骤


*1
    POST /v1/auth/vcode
        参数:    phonenum=手机号
    RETURN:
        { "result": true,
          "message": "验证码已发送" }
        OR:
        { "result": false,
          "message": 错误提示 }

*2
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
                "password": 密码(直接返回登陆的密码，验证码登陆会返回空),
                "access_token": "S1AVJulRj22ZwzDAcLB4-zL2Y1kYMZt1_1434246288"
                }
        }

##request 标识认证信息

*[Http Basic(https://zh.wikipedia.org/zh-sg/HTTP%E5%9F%BA%E6%9C%AC%E8%AE%A4%E8%AF%81)]
*access_token
    在所有url后 + ?access_token=登陆成功返回的access_token




