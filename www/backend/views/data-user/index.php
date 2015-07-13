<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use common\models\District;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '数据';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="data-daily-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <!--?= Html::a('Create Data Daily', ['create'], ['class' => 'btn btn-success']) ?-->
    </p>

    <div id="w0" class="grid-view">
        <div>
            <?php $form = ActiveForm::begin([
                'method'    => 'get',
                'action'    => '/data-user',
            ]); 
                // 城市选项
                $model  = new District();
                $city   = $model->find()->where(['level'=>'province'])->asArray()->all();
                $cityarr= array(0=>'全部--暂时无效');
                foreach( $city as $k => $v ){
                    $cityarr[$v['id']]    = $v['name'];
                }
            ?>
                
                <div class="form-group field-district-level required">
                    <select id="district-level" class="form-control" name="type_id">
                    <option value="1" <?php if( Yii::$app->request->get('type_id') ==1 ){echo 'selected';} ?>>用户端</option>
                    <option value="2" <?php if( Yii::$app->request->get('type_id') ==2 ){echo 'selected';} ?> >职位</option>
                    <option value="3" <?php if( Yii::$app->request->get('type_id') ==3 ){echo 'selected';} ?>>微信</option>
                    </select>
                    <div class="help-block"></div>
                </div> 

                <div class="form-group field-district-level required">
                    <select id="district-level" class="form-control" name="city_id">
                        <?php foreach($cityarr as $k => $v){ ?>
                            <option value="<?= $k ?>"><?= $v ?></option>
                        <?php } ?>
                    </select>
                    <div class="help-block"></div>
                </div> 

                起始日期：
                <?= DatePicker::widget([
                    'name' => 'dateStart',
                    'value' => $dateStart,
                    //'template' => '{addon}{input}',
                    'clientOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd'
                    ]
                ]);?>
                结束日期：
                <?= DatePicker::widget([
                    'name' => 'dateEnd',
                    'value' => $dateEnd,
                    //'template' => '{addon}{input}',
                    'clientOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd'
                    ]
                ]);?>
                &nbsp;
                <button class="btn btn-success" type="submit">搜索</button>
                &nbsp;&nbsp;快速查看：
                <a href="/data-user?type_id=<?= $data_type ?>&city_id=<?= $city_id ?><?= $ztUrl ?>">昨天</a> | 
                <a href="/data-user?type_id=<?= $data_type ?>&city_id=<?= $city_id ?><?= $qtUrl ?>">7天</a> | 
                <a href="/data-user?type_id=<?= $data_type ?>&city_id=<?= $city_id ?><?= $sstUrl ?>">30天</a>
            <?php ActiveForm::end(); ?>
        </div>
        <div>&nbsp;</div>
        <?php if($data_type==3){ ?>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>日期</th>
                    <th>总关注</th>
                    <th>当日关注</th>
                    <th>总退订</th>
                    <th>当日退订</th>
                    <th>当日推送人数</th>
                    <th>当日推送总量</th>
                    <th>当日微信注册</th>
                    <th>当日微信投递人数</th>
                    <th>当日微信投递总量</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($dataRows as $k => $v){ ?>
                <tr data-key="2">
                    <td><?= isset($v['date']) ? $v['date'] : 0 ?></td>
                    <td><?= isset($v['zgz']) ? $v['zgz'] : 0 ?></td>
                    <td><?= isset($v['jrgz']) ? $v['jrgz'] : 0 ?></td>
                    <td><?= isset($v['ztd']) ? $v['ztd'] : 0 ?></td>
                    <td><?= isset($v['jrtd']) ? $v['jrtd'] : 0 ?></td>
                    <td><?= isset($v['jrtsrs']) ? $v['jrtsrs'] : 0 ?></td>
                    <td><?= isset($v['jrtszl']) ? $v['jrtszl'] : 0 ?></td>
                    <td><?= isset($v['jrwxzc']) ? $v['jrwxzc'] : 0 ?></td>
                    <td><?= isset($v['jrwxtdrs']) ? $v['jrwxtdrs'] : 0 ?></td>
                    <td><?= isset($v['jrwxtdzl']) ? $v['jrwxtdzl'] : 0 ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php }elseif($data_type==2){ ?>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>日期</th>
                    <th>总贴量</th>
                    <th>总在线贴量</th>
                    <th>后台新增</th>
                    <th>抓取新增</th>
                    <th>用户新增</th>
                    <th>总待审核</th>
                    <th>总过期</th>
                    <th>当日过期</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($dataRows as $k => $v){ ?>
                <tr data-key="2">
                    <td><?= isset($v['date']) ? $v['date'] : 0 ?></td>
                    <td><?= isset($v['ztl']) ? $v['ztl'] : 0 ?></td>
                    <td><?= isset($v['zzxtl']) ? $v['zzxtl'] : 0 ?></td>
                    <td><?= isset($v['htxz']) ? $v['htxz'] : 0 ?></td>
                    <td><?= isset($v['zqxz']) ? $v['zqxz'] : 0 ?></td>
                    <td><?= isset($v['yhxz']) ? $v['yhxz'] : 0 ?></td>
                    <td><?= isset($v['zdsh']) ? $v['zdsh'] : 0 ?></td>
                    <td><?= isset($v['zgq']) ? $v['zgq'] : 0 ?></td>
                    <td><?= isset($v['jrgq']) ? $v['jrgq'] : 0 ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php }else{ ?>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>日期</th>
                    <th>注册总量</th>
                    <th>简历总量</th>
                    <th>投递总量</th>
                    <th>投递人数</th>
                    <th>当日注册总量</th>
                    <th>当日简历总量</th>
                    <th>当日投递总量</th>
                    <th>当日投递人数</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($dataRows as $k => $v){ ?>
                <tr data-key="2">
                    <td><?= isset($v['date']) ? $v['date'] : 0 ?></td>
                    <td><?= isset($v['zczl']) ? $v['zczl'] : 0 ?></td>
                    <td><?= isset($v['jlzl']) ? $v['jlzl'] : 0 ?></td>
                    <td><?= isset($v['tdzl']) ? $v['tdzl'] : 0 ?></td>
                    <td><?= isset($v['tdrs']) ? $v['tdrs'] : 0 ?></td>
                    <td><?= isset($v['jrzczl']) ? $v['jrzczl'] : 0 ?></td>
                    <td><?= isset($v['jrjlzl']) ? $v['jrjlzl'] : 0 ?></td>
                    <td><?= isset($v['jrtdzl']) ? $v['jrtdzl'] : 0 ?></td>
                    <td><?= isset($v['jrtdrs']) ? $v['jrtdrs'] : 0 ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php } ?>
    </div>

</div>

<?php $this->beginBlock('css') ?>
    <link href="/css/jquery.timepicker.css" media="all" rel="stylesheet" />
<?php $this->endBlock('css') ?>
<?php $this->beginBlock('js') ?>
    <script src="/js/jquery.timepicker.min.js" ></script>
<?php $this->endBlock() ?>

