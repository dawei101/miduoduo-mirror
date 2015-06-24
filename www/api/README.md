
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
    * GET http://api.test.chongdd.cn/v1/task
* 获取某服务类别的task
    GET (http://api.test.chongdd.cn/v1/task?filters=[["=", "service_type_id", 10]])

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

### 职位
* 职位列表
    * GET /version/task?expand=company,service_type,city,district,user
* 职位详情
    * GET /version/task/gid

* 职位
```
    {
      "gid": "14339329187365",
      "title": "传单发兼职",
      "clearance_period": 0,
      "salary": "120.00",
      "salary_unit": 0,
      "salary_note": "",
      "from_date": "2015-06-03",
      "company_name": "北京宠爱有家信息技术有限公司",
      "company_introduction": null,
      "contact": null,
      "contact_phonenum": null,
      "to_date": "2015-06-20",
      "from_time": "10:00:00",
      "to_time": "20:00:00",
      "need_quantity": 100,
      "got_quantity": 0,
      "created_time": "2015-06-10 18:41:58",
      "updated_time": null,
      "detail": "Alter table jz_resume add job_wishes varchar(1000);Alter table jz_resume add job_wishes varchar(1000);Alter table jz_resume add job_wishes varchar(1000);",
      "requirement": "",
      "address": "京市北京朝阳冠军城",
      "age_requirement": null,
      "height_requirement": null,
      "status": 0,
      "user_id": 5,
      "service_type_id": 1,
      "city_id": 3,
      "district_id": 4,
      "company_id": 0,
      "gender_requirement": null,
      "degree_requirement": null,
      "city": {
        "id": 3,
        "parent_id": 2,
        "name": "北京市",
        "level": "city",
        "citycode": "010",
        "postcode": "110100",
        "center": "116.405285,39.904989",
        "full_name": "北京市-北京市市辖区",
        "disabled": 0
      },
      "district": {
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
      "user": {
        "id": 5,
        "username": "18661775819",
        "email": null,
        "status": 0,
        "created_time": "2015-06-09 20:29:55",
        "updated_time": "2015-06-23 15:21:43",
        "name": null,
        "is_staff": 0
      },
      "service_type": {
        "id": 1,
        "name": "传单",
        "created_time": null,
        "updated_time": null,
        "modified_by": "",
        "status": 0
      },
      "company": null
    },
```

###简历 Resume

* 获取自己简历
    * GET /version/resume/user_id
* 更新自己简历
    * PUT /version/resume/user_id

###时间表 Freetime

* 获取自己的时间表
    * GET /version/freetime
* 获取某天的时间表
    * GET /version/freetime/user_id,day_of_week
    * day_of_week ＝ range(1-7)
* 更新某天的时间表
    * PUT /version/freetime/user_id,day_of_week
    * post params = {"morning": 1, "afternoon": 0}  | "evening"
    * 参数可以提交多个

###Address 地址
* 获取地址列表
    * GET /version/address
* 添加新地址
    * POST /version/address
    * params: province,city,district,address,lat,lng,user_id
* 修改已有地址
    * PUT /version/address/id
    * params: province,city,district,address,lat,lng,user_id

###任务报名

* 获取已报名的任务列表 
    * GET /version/task-applicant?expand=task
* 报名某任务
    * PUT /version/task-applicant
    * params: user_id, task_id
* 取消报名某任务
    * DELETE /version/task-applicant/user_id,task_id

###Message 消息
* 获取消息列表
    * GET /version/sys-message
* 获取消息详情(用不到)
    * GET /version/sys-message/id

###User 资料
* 获取当前用户资料
    * GET /version/user/user_id

###收藏

* 获取收藏的任务列表 
    * GET /version/task-collection?expand=task
* 收藏某任务
    * PUT /version/task-collection
    * params: user_id, task_id
* 取消收藏某任务
    * DELETE /version/task-collection/user_id,task_id


### 关于跨域
[Http access control - CORS](https://en.wikipedia.org/wiki/Cross-origin_resource_sharing)
原理：
* 浏览器发送http request 带着 origin
* 服务器http response 带着 Access-Control-Allow-Origin
    * 例 Access-Control-Allow-Origin: http://m.miduoduo.cn
欲知详情请深挖[Wiki](https://en.wikipedia.org/wiki/Cross-origin_resource_sharing)

