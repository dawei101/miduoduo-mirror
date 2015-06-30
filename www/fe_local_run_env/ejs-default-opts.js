var destRootPath = "/m/web/origin/";
var destCssRootPath = destRootPath + "less/";
var destJsRootPath = destRootPath + "js/";
options = {
    title : "",
    setTitle : function(param) { this.title = param},
    baseUrl : destRootPath,
    baseCssUrl : destCssRootPath,
    baseJsUrl : destJsRootPath,
    styleFileExt : ".less",
    mainJs : function(param) {
        return "<script>seajs.use('" + param + "')</script>";
    },
    css : function(param) {
        if (typeof param == "string") {
            return "<link rel='stylesheet' type='text/css' href='" + destCssRootPath + param + ".less'/>"
        } else if (param instanceof Array) {
            var linkStr = "";
            param.forEach(function(e) {
                linkStr += "<link rel='stylesheet' type='text/css' href='" + destCssRootPath + e + ".less'/>\n";
            })
            return linkStr;
        }
    }

}
exports.options = options;