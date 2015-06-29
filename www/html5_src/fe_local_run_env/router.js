/**
 * 前段测试服务器
 * 响应静态文件、解析view文件、解析less文件
 * @type {exports}
 */
var fs = require("fs");
var url = require('url');
var querystring = require('querystring');
var config = require("./config");
var mime = require("./mime");
var ejs = require("./node_modules/ejs");
var ejsDefaultOpts = require("./ejs-default-opts");
var less = require("./node_modules/less");

function route(req, res) {
    var reqUrl = url.parse(req.url);
    console.log(reqUrl.pathname);
    if (reqUrl.pathname == "/favicon.ico") {
        res.end();
        return;
    }
    var pathName = reqUrl.pathname;
    var fileType = getFileype(pathName);
    if (fileType == "ico") {

    }

    var filePath = getFilePath(fileType, pathName);
    loadFile(fileType, filePath, res);


}

/**
 * 读取文件，并响应给客户端
 * @param fileType
 * @param filePath
 * @param res
 */
function loadFile(fileType, filePath, res) {
    var fileStr;
    switch(fileType) {
        case "html" :
            fs.readFile(filePath , 'utf8', function(err, file) {
                if (err) {
                    onErr(filePath, res);
                    return;
                }
                fileStr = ejs.render(file, ejsDefaultOpts.options, {filename : "../view/header.html"})
                responseReq(fileStr, fileType, res)
            })

            break;
        case "js" :
            fs.readFile(filePath , 'utf8', function(err, file) {
                if (err) {
                    onErr(filePath, res);
                    return;
                }
                responseReq(file, fileType, res)
            })
            break;
        case "less" :
            fs.readFile(filePath , 'utf8', function(err, file) {
                if (err) {
                    onErr(filePath, res);
                    return;
                }
                var parser = new(less.Parser)({
                    paths: ["../less"]
                })
                parser.parse(file , function(err ,tree){
                    file = tree.toCSS({ compress: true })
                    responseReq(file, fileType, res)
                })

            });
            break;
        default :
            fs.readFile(filePath , 'binary', function(err, file) {
                if (err) {
                    onErr(filePath, res);
                    return;
                }
                responseReq(file, fileType, res, "binary")
            });
    }
}

/**
 *
 * @param fileStr
 * @param fileType
 * @param res
 * @param encoding  图片等二进制文件时需要binary
 */
function responseReq(fileStr, fileType, res, encoding) {
    res.writeHeader(200 ,{
        'Content-Type' :  mime.types[fileType] +';charset=utf-8'
    });
    res.write(fileStr, encoding || "utf8");
    res.end();
}

/**
 * 获取文件类型
 * @param url
 * @returns {string}
 */
function getFileype(url){
    var pos = url.lastIndexOf('.');
    if (!pos ) return;
    return url.substr(pos +1);

}

/**
 * 获取文件路径
 * @param fileType
 * @param pathName
 */
function getFilePath(fileType, pathName) {
    var filePath;
    switch(fileType) {
        case "html" :
            filePath = config.fileRootPath + pathName;
            break;
        case "js" :
        case "less" :
        default :
            filePath = ".." + pathName;

    }
    return filePath;
}

function onErr (filepath ,res){
    res.writeHead( 404 ,{'Content-Type' : 'text/plain'});
    res.write( filepath + ' is lost');
    res.end();
    console.log(filepath,' is lost')

}
exports.route = route;