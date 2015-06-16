(function(){
document.addEventListener('WebViewJavascriptBridgeReady', function() {
     WebViewJavascriptBridge.defaultHandler(handle_action)
    }, false);

function handle_action(data, responseCallback) {
    data = {
            action: 'q_before_quit',
            data: {}
            }
    return = {
        action: 'q_before_quit',
        result: {
            value: true,
            message: '一般只用于不能退出提示',
            }
        }
    responseCallback(return);
});

var $jb = {};

var action_profix = 'b_';
var default_actions_params = {
    'require_auth': {
        'message': '请先登陆',
    },
    'alert': {
        'disappear_delay': -1, //整数，显示n毫秒后消失
        'title': '升级提示',
        'message': '米多多兼职',
        'operation' => ['取消', '确定']
    },
    'toast_alert': {
        'message': '恭喜你登陆成功',
        'disappear_delay': 3500, //显示n毫秒后消失
    },
    'push': {
        'url': ,
        'has_nav': true,
        'has_tab': false,
        'title': 'push 新页面',
        //todo
        'left_action': {title: '消息' ,action: {'action': 'b_pop','data' : data}, // null可以取消任何显示
        'right_action': {title: '消息' ,action: {'action':action,'data' : data}],
    },
    'pop': {},
    'get_address': {
        'title': '附近地点'
    },
    'get_current_location': {},
    'start_processing': {
        'message': '加载中...',
    },
    'stop_processing': {},
};

function build_action(name, default_params){
    var f = function(params){
        var callback = params.callback;
    };
    return f;
}

for (var name in default_actions_params){
    var data = default_params[i];
}


function formatData(action, data){
    return {action: action, data: data};
}

function invoke(action, data, callback){
    json = {action: action, data: data};
    WebViewJavascriptBridge.send(, function(r){
        if (callback!=undefined){ callback(r.result); }
    });
}


var require_auth = function(data){
    invoke('b_require_auth', {message: message}, callback)
};
var alert = function(title, message, display_time){
};

var toast_alert = fucntion(message, disappear_delay){
    invoke('b_toast_alert', {message: message, disappear_delay: disappear_delay==undefined?3:disappear_delay});
};

var push = function(has_nav, title, has_tab, ){
};
})();
