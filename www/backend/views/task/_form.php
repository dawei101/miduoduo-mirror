<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use dosamigos\tinymce\TinyMce;
use common\models\ServiceType;
use common\models\District;

/* @var $this yii\web\View */
/* @var $model common\models\Task */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="task-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'labels_str')->label("标签(以英文','分隔)") ?>

    <?= $form->field($model, 'clearance_period')->dropDownList(
        $model::$CLEARANCE_PERIODS
    ) ?>

    <?= $form->field($model, 'salary')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'salary_unit')->dropDownList(
        $model::$SALARY_UNITS
    ) ?>

    <?= $form->field($model, 'salary_note')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'from_date')->widget(
        DatePicker::className(), [
            'model'=>$model,
            'attribute' => 'from_date',
            'dateFormat' => 'yyyy-MM-dd',
        ]) ?>

    <?= $form->field($model, 'to_date')->widget(
        DatePicker::className(), [
            'model'=>$model,
            'attribute' => 'birthdate',
            'dateFormat' => 'yyyy-MM-dd',
        ]) ?>


    <?= $form->field($model, 'from_time')->textInput() ?>

    <?= $form->field($model, 'to_time')->textInput() ?>

    <?= $form->field($model, 'need_quantity')->textInput() ?>

    <?= $form->field($model, 'detail')->widget(
        TinyMce::className(), [
            'options' => ['rows' => 6],
            // http://www.tinymce.com/wiki.php/Configuration:language 
            // vendor/2amigos/yii2-tinymce-widget/src/assets/langs
            'language' => 'zh_CN',
            'clientOptions' => [
                'plugins' => [
                    "advlist autolink lists link charmap print preview anchor",
                    "searchreplace visualblocks code fullscreen",
                    "insertdatetime media table contextmenu paste"
                ],
                'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | image |"
            ]
        ]) ?>

    <?= $form->field($model, 'requirement')->textarea(['rows' => 6]) ?>


    <?php 

        $city_map = [];
        foreach(District::getCities() as $city){
            $city_map[$city->id] = $city->name;
        }
        $model->city_id = 3;

        $district_map = [];
        foreach(District::getDistricts($model->city_id) as $district){
            $district_map[$district->id] = $district->name;
        }
    ?>
    <?php
        $service_types = [];
        foreach (ServiceType::find()->all() as $t){
            $service_types[$t->id] = $t->name;
        }
    ?>
    <?= $form->field($model, 'service_type_id')->dropDownList(
        $service_types
    ) ?>

    <?= $form->field($model, 'contact') ?>
    <?= $form->field($model, 'contact_phonenum') ?>
    <?= $form->field($model, 'company_id')->hiddenInput($options=['id'=>'company-id']) ?>
    <div class="input-group">
          <input id="keyword" autocomplete="off" type="text" class="form-control" placeholder="输入公司名"
            value="<?=$model->company?$model->company->name:''?>"
            >
          <span class="input-group-btn">
            <button id="search" class="btn btn-default" type="button">搜索</button>
          </span>
    </div>
    <ul class="list-group" id="search-result">
    </ul>
    <p class="text-right"> OR
        <a href="/company/create" target="_blank" class="btn btn-danger">添加新公司</a>
    </p>
    <br />
    <div class="form-group">
        <?= Html::submitButton('下一步', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php $this->beginBlock('js') ?>
<script>
$(function(){
    var cipt = $("#company-id");
    var sr = $("#search-result");
    var kwipt = $("#keyword");
    var companies = [];

    function set_company(i){
        var c = companies[i];
        cipt.val(c.id);
        kwipt.val(c.name);
        sr.html('');
    }
    window.set_company = set_company;

    function search(){
        var kw = kwipt.val();
        if (kw){
            $.ajax({url: '/company/search?keyword=' + kw, 
            }).done(function(data_s){
                var data = $.parseJSON(data_s);
                companies = data;
                var lis = '';
                for (var i in data){
                    var s = '<li onclick="set_company('+i+')" class="list-group-item">' + data[i].name + '</li>';
                    lis += s;
                }
                sr.html(lis);
            });
        }
    }

    $("#search").bind(GB.click_event, function(){
        search();
    });
});
</script>
<?php $this->endBlock() ?>
