define(function(require,exports){function authCodeTimer(count,$this,delay){setTimeout(function(){$this.text("重新获取"+count+"s"),count--,count>0?authCodeTimer(count,$this,1e3):($this.text("重新获取"),$this.removeClass("auth-code-sleep"))},delay||0)}require("zepto-ext");var api=require("../widget/api"),duang=require("../widget/duang");$(".auth-code-btn").on("click",function(){if(!$(this).hasClass("auth-code-sleep")){var $this=$(this);$.post(api.gen("entry/vcode"),{phonenum:$(".tel-password-tel-input").val()},function(data){data.success?($this.addClass("auth-code-sleep"),authCodeTimer(60,$this)):duang.toast(data.message)},"json")}}),$(".next-btn").on("click",function(){var $this=$(this);$(this).hasClass("confirm-submit")?$.post(api.gen("user/set-password"),{password:$(".tel-password-first-input").val(),password2:$(".password-reset-second-input").val()},function(data){data.success?(miduoduo.user.access_token=data.result.access_token,duang.toast(data.message,function(){window.history.back()})):duang.toast(data.message)},"json"):$.post(api.gen("entry/vlogin"),{phonenum:$(".tel-password-tel-input").val(),code:$(".tel-password-code-input").val()},function(data){data.success?(miduoduo.user.access_token=data.result.access_token,$(".tel-password").hide(),$(".password-reset").show(),$this.addClass("confirm-submit"),$this.text("提交")):duang.toast(data.message)},"json")})});