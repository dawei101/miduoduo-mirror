var http = require('http');
var querystring = require('querystring'),
    keepAliveAgent = require(config.path.lib + 'agent.js'),
    cookie = require(config.path.base + 'cookie.js')

var hosts = {"web" :  "http://api.test.chongdd.cn"},
    port = 80,
    debug = config.api.debug;

var agent = config.etc.maxSockets ? new keepAliveAgent({ maxSockets: config.etc.maxSockets }) : false

function create(req ,res , notify) {

    return function(remoteUri , method, reqAct , data){
        var reqHeaders = reqAct ? {'request' : reqAct} : {};
        if (!method ) { method = 'GET';}
        var hostSource = 'web'
        var host = hosts[hostSource]
        if (!host){
            console.log("没指定远程主机");
        }
        var data = querystring.stringify(data);
        var proxyHeaders = reqHeaders;
        var proxyDomain = ['XREF', 'seashell' , 'clientIp' , 'referer' , 'cookie' , 'user-agent' ];
        proxyHeaders.reqHost = req.headers.host
        proxyHeaders.requrl = req.url
        proxyHeaders.targetEnd = hostSource
        for(var i=0,j = proxyDomain.length ; i < j ;i++ ){
            if (req.headers.hasOwnProperty(proxyDomain[i]) ) {
                proxyHeaders[proxyDomain[i]] = req.headers[proxyDomain[i]]
            }
        }

        if ('GET' == method){
            if (data) {
                remoteUri = remoteUri.trim()
                remoteUri += (remoteUri.indexOf('?')>0 ? '&' : '?') + querystring.stringify(data);
            }
            data = ''
        }else{
            proxyHeaders['Content-Type'] =  'application/x-www-form-urlencoded'
        }
        proxyHeaders['Content-Length'] =  Buffer.byteLength(data,'utf8') //data.length

        var options = {
            host : host,
            port : port ,
            headers: proxyHeaders,
            path : remoteUri,
            agent : agent,
            method : method
        };
        var request_timer;
        var st1 = new Date;
        var request = http.request(options , function(response) {
            request_timer && clearTimeout(request_timer);
            request_timer = null
            //console.log('STATUS: ' + response.statusCode);
            //response.setEncoding('utf8');

            var res_state = response.statusCode;
            if  (200 != res_state && 400 != res_state && 4000 > res_state) {
               console.log("api请求出错");
            }
            var result = '';
            response.on('data', function (chunk) {
                result += chunk;
            }).on('end' , function(){

                if (400 == res_state){

                }

                if ('""' == result) result = false

                var proxyDomains = ['set-cookie']
                for (var i = proxyDomains.length-1;i>=0 ;i--){
                    var proxyKey = proxyDomains[i]
                    if (proxyKey in response.headers){
                        var pdVal = response.headers[proxyKey]
                        if (!pdVal) break
                        if ('set-cookie' == proxyKey) {
                            var cookie_set = cookie.getHandler(req , res)
                            pdVal.forEach(function(cookie_v){
                                cookie_set.set(cookie_v)
                            })
                        }else
                            res.setHeader( proxyKey , pdVal)

                    }
                }
                return evt ? evt(result , res_state) : result;
            });
        });

        return function(evt , data ) {
            if (!host)   return evt ? evt(false) : {};

            if ('undefined' == typeof data && 'function' != typeof evt){
                data = evt;
                evt = null;
            }


            request.on('error' , function(e){
                base.errorLog('error' , 'api' ,remoteUri , e.message )
                evt && evt(false);

            });
            request_timer = setTimeout(function() {
                request_timer = null
                request.abort();
                base.errorLog('error' , 'api' ,remoteUri , 'Request Timeout' )
                return evt ? evt(false) : {};
            }, config.api.timeout);
            notify && notify.on('abort' , function(){
                if (!request_timer) return
                clearTimeout(request_timer)
                request.abort()
                base.errorLog('error' , 'api' ,remoteUri , 'User Abort' )
            })


            request.write(data);
            request.end();

        }

    }
}

exports.__create = create;
