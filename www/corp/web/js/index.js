//首页登陆
$('#login .zc-btn').click(function(e){
    $.post('/user/login', $(this).closest('form').serialize())
    .done(function(data){
        var data = JSON.parse(str);
        if (data.result === true) {
            window.location = '/task/';
            return;
        }
    });
    return false;
});

//首页注册
$('#hr .zc-btn').click(function(e){
    $.post('/user/register', $(this).closest('form').serialize())
    .done(function(str){
        var data = JSON.parse(str);
        if (data.result === true) {
            window.location = '/user/add-contact-info';
            return;
        }
    });
    return false;
});

//注册发送验证码
$('.yz-btn').on('click', function(){
    $.get('/user/vcode', $(this).closest('form').serialize())
    .done(function(data){
        console.log(data);
    });
});
