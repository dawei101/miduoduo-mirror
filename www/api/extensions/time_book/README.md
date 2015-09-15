考勤api文档
-------------------

考勤的身份验证
======================
同api身份验证
如第三方使用，将需要使用米多多OAuth2.0 登陆方式登陆方可（第三方登陆暂未开通）


考勤api
======================
Baseurl = //api.miduoduo.cn/time-book/

### 获得用户日程
```
    GET /time-book/schedule?date=2015-08-09
    RETURN :
    {
      "items": [
        {
          "id": 24,
          "user_id": "5",
          "task_id": "472",
          "from_datetime": "2015-09-09 07:00:00",
          "to_datetime": "2015-09-09 10:00:00",
          "allowable_distance_offset": 500,
          "date": "2015-09-09",
          "owner_id": "5",
          "on_late": 0,
          "off_early": 0,
          "out_work": 0,
          "note": null,
          "lng": 116.411065,
          "lat": 39.996498,
          "address": "北京 朝阳 加利大厦 ",
          "task_title": " 米多多"
        }
      ],
      "_links": {
        "self": {
          "href": "http://api.liyw.chongdd.cn/time-book/schedule?date=2015-09-09&page=1"
        }
      },
      "_meta": {
        "totalCount": 1,
        "pageCount": 1,
        "currentPage": 1,
        "perPage": 20
      }
    }
```


### 考勤打卡
    POST /time-book/record
    params: 
        lat=
        lng=
        schedule_id=
        action=on/off
    return 
    {
        "lat": "39.9829512",
        "lng": "116.452629",
        "schedule_id": "508",
        "user_id": "2006",
        "owner_id": "6951",
        "event_type": 1,
        "id": 147
    }
    OR
    {
        "success": false,
        "message": "您不在打卡范围内！"
    }
```
