<?php

?>

<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use common\models\District;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '报名统计';
$this->params['breadcrumbs'][] = $this->title;

$cities = [];
foreach (District::findAll(['level'=>'city', 'is_alive'=>1]) as $city){
    $cities[$city_id] = $city->short_name;
}
?>
<div class="data-daily-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <table>
        <th>
            <td>城市名</td> <td> 今日报名</td> <td> 报名变化</td>
        </th>
    <?php foreach ($data as $row) { ?>
        <tr>
        <td><?=$cities[$row['city_id']]?></td>
        <td><?=$row['count']?></td>
        <td><?=$row['increase']?></td>
        </tr>
    <?php } ?>


    </table>

</div>
