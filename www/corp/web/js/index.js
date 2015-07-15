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
        	$(".error-message").html(error);
        	$(".error-message").show();
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
        	$(".error-message").html(error);
        	$(".error-message").show();
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
        	$(".error-message").html(error);
        	$(".error-message").show();
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
        $('.error-message').show(2);
        return;
    }
    if(!phone.match(/^1[3|4|5|8][0-9]\d{4,8}$/)){
        $('.error-message').html("请输入正确的手机号");
        $('.error-message').show(2);
        return;
    }
	$(this).removeClass('yz-btn');
	$(this).addClass('yz-btn-jx');
    counter($(this), 60);
    $.get('/user/vcode', $(this).closest('form').serialize())
    .done(function(data){
        console.log(data);
    });
});

function counter($el, n) {
    (function loop() {
       $el.html("重新发送(" + n + ")");
       if (n--) {
           setTimeout(loop, 1000);
       }else {
           $el.addClass('yz-btn');
       	   $el.removeClass('yz-btn-jx');
              $el.html('发送验证码');
       }
    })();
}
