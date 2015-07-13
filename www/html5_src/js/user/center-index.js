define(function(require, exports) {
    require("zepto-ext");
    var api = require("../widget/api");
    var util = require("../widget/util");
    var $obj = $(".state");

    //如果登陆，展示用户id
    if (miduoduo.user.id) {
        $obj.append(miduoduo.user.username);
    } else {
        $obj.find("span").css("display", "inline-block");
    }

    //我的简历跳转逻辑
    if (miduoduo.user.id) {

        $.pageInitGet(api.gen("resume?expand=service_types,freetimes,home_address,workplace_address"), function(data) {
            console.log(data);
            if (data.items && data.items.length > 0) {
                $(".js-my-resume").attr("href", "view/user/resume-preview.html");
            } else {
                $(".js-my-resume").attr("href", "view/user/resume-input.html");
            }
        });
    }

    //注册、登陆
    $(".state").find("span").on("click", function() {
        util.auth();
    });
    $(".item").on("click", function(e) {
        e.preventDefault();
        if (miduoduo.user.id) {
            util.href($(this).attr("href"));
        } else {
            util.showTips("您还没有登陆！");
        }
    });

});