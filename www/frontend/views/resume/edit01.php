<?php
use yii\helpers\Html;
use yii\bootstrap\ButtonGroup;
use yii\bootstrap\ActiveForm;

use common\models\Resume;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginWithDynamicCodeForm */

$this->title = '简历录入';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-lg-8">
<?php $form = ActiveForm::begin(['id' => 'edit-resume-form']); ?>
        <?= $form->field($model, 'name') ?>
        <?= $form->field($model, 'gender')
            ->dropDownList(Resume::$GENDERS)?>
        <?= $form->field($model, 'grade')
            ->dropDownList(Resume::$GRADES)?>
        <?= ($model->isNewRecord)?$form->field($model, 'origin'):'' ?>
        <div class="form-group">
            <label class="control-label">空闲时间</label>
            <table class="table table-bordered">
              <thead>
               <tr class="active">
                  <th>#</th>
                  <th>上午</th>
                  <th>中午</th>
                  <th>下午</th>
                </tr>
              </thead>
              <tbody>
        <?php
        $day_names = ['一', '二', '三', '四', '五', '六', '日'];
        for($i=0; $i<=6; $i++){
            $m = $a = $e = '';
            if (isset($freetimes[$i+1])){
                $ft = $freetimes[$i+1];
                $m = $ft->morning?      'availiable':'';
                $a = $ft->afternoon?    'availiable':'';
                $e = $ft->evening?      'availiable':'';
            }
            echo "
                <tr>
                  <th scope='row'>周$day_names[$i]</th>
                  <td class='diy-checkbox $m' data-when='morning'   data-dayofweek='" . ($i+1) . "'>&nbsp;</td>
                  <td class='diy-checkbox $a' data-when='afternoon' data-dayofweek='" . ($i+1) . "'>&nbsp;</td>
                  <td class='diy-checkbox $e' data-when='evening'   data-dayofweek='" . ($i+1) . "'>&nbsp;</td>
                </tr>";
        }
        ?>
              </tbody>
            </table>
        </div>
        <div class="form-group">
            <?= Html::submitButton('提交', ['class' => 'btn btn-danger col-xs-12', 'name' => 'login-button']) ?>
        </div>
<?php ActiveForm::end(); ?>
    </div>
</div>
<?php $this->beginBlock('js') ?>
<script  type="text/javascript">
$(function(){
    $('.diy-checkbox').bind(GB.click_event,
        function(){
            var _this=$(this);
            $.ajax({url: './freetimes',
                'method': 'POST',
                'data': {'dayofweek': _this.attr('data-dayofweek'),
                    'when': _this.attr('data-when'),
                    'is_availiable': _this.hasClass('availiable')?'0':'1'
                }
            }).done(function(text){
                 data=$.parseJSON(text);
                 if (data['result']){
                     data['is_availiable']?_this.addClass('availiable'):_this.removeClass('availiable');
                 } else {
                 }
            });
        });
});
</script>
<?php $this->endBlock('js') ?>
<?php $this->beginBlock('css') ?>
<style>
.diy-checkbox.availiable{
    background: #00CC99;
}
.diy-checkbox:hover{
    cursor:pointer;
}
</style>
<?php $this->endBlock('css') ?>
