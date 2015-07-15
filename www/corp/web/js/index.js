//首页普通登陆
$('#cbox-2 .myNavs .zc-btn').click(function(e){
    $(".error-message").hide();
    $.post('/user/login', $(this).closest('form').serialize())
    .done(function(str){
        var data = JSON.parse(str);
        if (data.result === true) {
            window.location = '/task/';
            return;
        }else{
        	var error = '';
        	if(data.error.username){
        		error += data.error.username[0];
        	}
        	if(data.error.password){
        		error += data.error.password[0];
        	}
        	$("#cbox-2 .myNavs .error-message").html(error);
        	$("#cbox-2 .myNavs .error-message").show();
        }
    });
    return false;
});

$('#cbox-2 .hotNavs .zc-btn').click(function(e){
    $(".error-message").hide();
    $.post('/user/vlogin', $(this).closest('form').serialize())
    .done(function(str){
        var data = JSON.parse(str);
        if (data.result === true) {
            window.location = '/task/';
            return;
        }else{
        	var error = data.error;
        	$("#cbox-2 .myNavs .error-message").html(error);
        	$("#cbox-2 .myNavs .error-message").show();
        }

    });
    return false;
});

//首页注册
$('#cbox-1 .zc-btn').click(function(e){
    $(".error-message").hide();
    $.post('/user/register', $(this).closest('form').serialize())
    .done(function(str){
        var data = JSON.parse(str);
        if (data.result === true) {
            window.location = '/user/add-contact-info';
            return;
        }else{
        	var error = '';
        	if(data.error.username){
        		error += data.error.username[0];
        	}
        	if(data.error.vcode){
        		error += data.error.vcode[0];
        	}
        	if(data.error.password){
        		error += data.error.password[0];
        	}
        	$("#cbox-1 .error-message").html(error);
        	$("#cbox-1 .error-message").show();
        }
    });
    return false;
});

//注册发送验证码
$('.yz-btn').on('click', function(){
    $(".error-message").hide();
    var phone = $(this).closest('form').find('[name="username"]').val();
    if (phone.length == 0) {
        $('.error-message').html("请输入手机号");
        $('.error-message').show();
        return;
    }
	$(this).removeClass('yz-btn');
	$(this).addClass('yz-btn-jx');
	$(this).html('验证码已发送');
    $.get('/user/vcode', $(this).closest('form').serialize())
    .done(function(data){
        console.log(data);
    });
});
