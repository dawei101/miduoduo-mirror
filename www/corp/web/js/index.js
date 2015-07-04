//首页登陆
$('#login .zc-btn').click(function(e){
    $.get('/user/login', $(this).closest('form').serialize())
    .done(function(data){
        console.log(data);
    })
    return false;
});
