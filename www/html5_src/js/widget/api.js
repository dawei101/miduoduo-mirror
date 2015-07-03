define(function(require, exports) {
    //线上环境去掉下面这句
    miduoduo.config.access_token = "JRStEeKM4NFVvw5Ovy-I2gP3MEO1kK2A_1435923082";
    //通用版本
    var commonVersion = "http://api.test.chongdd.cn/v1/";
    //特别指定版本 key："partUrl"  val："version"
    var specialAssignVersionSet = {
        "apiUlr" : "/v2/"
    }
    function gen(partUrl) {
        partUrl.indexOf("?") > -1 ? partUrl += "&access_token=" + miduoduo.config.access_token : partUrl += "?access_token=" + miduoduo.config.access_token;
        var specialAssignVersion = specialAssignVersionSet[partUrl];
        if (specialAssignVersion) {
            return specialAssignVersion + partUrl;
        }
        return commonVersion + partUrl;
    }
    exports.gen = gen;
});