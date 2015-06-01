<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use common\models\Resume;
use yii\jui\DatePicker;


/* @var $this yii\web\View */
/* @var $model common\models\Resume */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="resume-form">


<?php
    if (!$model->isNewRecord)
        echo "<a class='btn btn-primary' href='/freetimes?user_id=" . $model->user_id . "'>编辑空闲时间</a>";
?>
<?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phonenum')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gender')->dropdownList(Resume::$GENDERS) ?>

    <?= $form->field($model, 'birthdate')->widget(
        DatePicker::className(), [
            'model'=>$model,
            'attribute' => 'birthdate',
            'dateFormat' => 'yyyy-MM-dd',
            'language' => 'Zh_cn'
        ]) ?>

    <?= $form->field($model, 'degree')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nation')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'height')->textInput(['type'=>'number', 'min'=>60, 'step'=>1, 'max'=>'230']) ?>

    <?= $form->field($model, 'is_student')->checkBox() ?>

    <?= $form->field($model, 'college')->textInput(['maxlength' => true]) ?>

    <?= ''//$form->field($model, 'avatar')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gov_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'grade')->dropDownList(Resume::$GRADES) ?>

    <?= $form->field($model, 'home')->textInput() ?>

    <?= $form->field($model, 'workplace')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '修改', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        &nbsp; &nbsp;
    </div>

    <?php ActiveForm::end(); ?>

</div>
