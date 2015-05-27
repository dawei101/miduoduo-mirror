<?php
use yii\helpers\Html;
use yii\bootstrap\ButtonGroup;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginWithDynamicCodeForm */

$this->title = '验证码登陆';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
        <div class="form-list">
          <?= $form->field($model, 'phonenum')->label('手机号')
              ->input('tel', $options = ['data-id'=>'phonenum'] ) ?>
          <div class="form-group">
            <label>验证码</label>
            <div class="yzm">
              <button type="button" id='svcode' class="btn btn-default form-yzm">获取验证码</button>
              <input type="text" id="loginwithdynamiccodeform-code"
                  class="form-control" name="<?= Html::getInputName($model, 'code')?>">
            </div>
            <p class="help-block help-block-error"></p>
          </div>
<?php $this->beginBlock('js') ?>
                <script>
                    $(function(){
                        var flag=false;
                        var vbtn = $("#svcode");
                        var pipt = $('input[data-id="phonenum"]');
                        var fp = pipt.closest('.form-group');
                        var help=fp.find('.help-block');
                        var wait=60;
                        function time(o) {
                            if (wait == 0) { 
                                o.addClass('btn-warning').removeClass('btn-default').removeAttr("disabled");
                                o.val("获取验证码");
                                wait = 60;
                            } else {
                                o.attr("disabled", true);
                                o.val(wait + "秒后重试");
                                wait--;
                                setTimeout(function() { time(o); }, 1000);
                            }
                        }

                        vbtn.bind('touchstart click', function(){
                            if (flag) {
                                return false;
                            }
                            flag = true;
                            setTimeout(function(){ flag = false; }, 100);
                            $.ajax({url: '/user/vcode',
                                'method': 'GET',
                                'data': {'phonenum': pipt.val()}})
                            .done(function(text){
                                data =$.parseJSON(text);
                                if (data['result']){
                                    time(vbtn);
                                    vbtn.removeClass('btn-warning').addClass('btn-default').attr("disabled","disabled");
                                } else {
                                    fp.addClass('has-error');
                                    help.html(data['msg']);
                                }
                            }).fail(function(){
                                fp.addClass('has-error');
                                help.html("网络出现问题，请重试.");
                            });
                        });
                    });
                </script>
<?php $this->endBlock('js') ?>
                <div class="form-group">
                    <?= Html::submitButton('下一步', ['class' => 'btn btn-danger col-xs-12', 'name' => 'login-button']) ?>
                </div>
        </div>
            <?php ActiveForm::end(); ?>
</div>
