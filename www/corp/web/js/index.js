//首页登陆
$('#login .zc-btn').click(function(e){
    $.get('/user/login', $(this).closest('form').serialize())
    .done(function(data){
        console.log(data);
    })
    return false;
});

//首页注册
$('#hr .zc-btn').click(function(e){
    $.get('/user/register', $(this).closest('form').serialize())
    .done(function(data){
        console.log(data);
    })
    return false;
});
