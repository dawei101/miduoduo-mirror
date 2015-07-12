//首页普通登陆
$('#cbox-2 .myNavs .zc-btn').click(function(e){
    $.post('/user/login', $(this).closest('form').serialize())
    .done(function(str){
        var data = JSON.parse(str);
        if (data.result === true) {
            window.location = '/task/';
            return;
        }
    });
    return false;
});

$('#cbox-2 .hotNavs .zc-btn').click(function(e){
    $.post('/user/vlogin', $(this).closest('form').serialize())
    .done(function(str){
        var data = JSON.parse(str);
        if (data.result === true) {
            window.location = '/task/';
            return;
        }
    });
    return false;
});

//首页注册
$('#cbox-1 .zc-btn').click(function(e){
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
