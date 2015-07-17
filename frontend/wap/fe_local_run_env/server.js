var http = require("http");
var fs = require("fs");
var router = require("./router");
var port =process.argv[2] || 8800;
function start(route, port) {
    http.createServer(function(req, res) {
        route(req, res);
    }).listen(port);
}

start(router.route, port);
console.log("服务启动，端口号", port);
