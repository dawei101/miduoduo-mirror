<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\Resume */

$this->title = '人力库';
$this->params['breadcrumbs'][] = $this->title;
?>
<table class="table table-striped">
  <thead>
    <tr>
      <th>#</th>
      <th>手机号</th>
      <th>姓名</th>
      <th>性别</th>
      <th>年级</th>
      <th>操作</th>
    </tr>
  </thead>
  <tbody>
<?php
foreach ($models as $model) {
    // display $model here
?>
    <tr>
      <th scope='row'><?= $model->id ?></th>
      <td><?= $model->phonenum ?></td>
      <td><?= $model->name ?></td>
      <td><?= $model->gender ?></td>
      <td><?= $model->grade ?></td>
      <td>
        <a class="btn btn-primary" href="/resume/edit?user_id=<?= $model->user_id ?>">编辑</a>
        &nbsp; &nbsp;
        <a class="btn btn-primary" href="/resume/freetimes?user_id=<?= $model->user_id ?>">空闲时间</a>
      </td>
    </tr>
<?php } ?>
  </tbody>
</table>

<?= LinkPager::widget([ 'pagination' => $pages, ]) ?>
