define(function(require,exports){function gen(partUrl){partUrl+=partUrl.indexOf("?")>-1?"&access_token="+miduoduo.config.access_token:"?access_token="+miduoduo.config.access_token;var specialAssignVersion=specialAssignVersionSet[partUrl];return specialAssignVersion?specialAssignVersion+partUrl:commonVersion+partUrl}miduoduo.config.access_token="JRStEeKM4NFVvw5Ovy-I2gP3MEO1kK2A_1435923082";var commonVersion="/v1/",specialAssignVersionSet={apiUlr:"/v2/"};exports.gen=gen});