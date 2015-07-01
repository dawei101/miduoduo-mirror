var http = require("http");
var fs = require("fs");
var router = require("./router");

function start(route, port) {
    http.createServer(function(req, res) {
        route(req, res);
    }).listen(port || 80);
}

start(router.route, 8800);
console.log("服务启动，端口号", 8800);
