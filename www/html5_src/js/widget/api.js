define(function(require, exports) {
    //线上环境去掉下面这句
   // miduoduo.user.access_token = "FeeZJwOwj2mrtDMusQGu5xhjpX2dmD5F_1436590845";
    //miduoduo.user.id = 5;
    var accessToken = miduoduo.user.access_token;
    //通用版本
    var commonVersion = window.miduoduo.api_baseurl;
    //特别指定版本 key："partUrl"  val："version"
    var specialAssignVersionSet = {
        "apiUlr" : "/v2/"
    }
    function gen(partUrl) {
        partUrl.indexOf("?") > -1 ? partUrl += "&access_token=" + accessToken : partUrl += "?access_token=" + accessToken;
        var specialAssignVersion = specialAssignVersionSet[partUrl];
        if (specialAssignVersion) {
            return specialAssignVersion + partUrl;
        }
        return commonVersion + partUrl;
    }
    exports.gen = gen;
});