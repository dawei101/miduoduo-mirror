<?php

use yii\widgets\LinkPager;

?>
 <ul class="tianxie-box1" style="border:none">
    <li>
      <input type="text" class="in_put" placeholder="兼职人姓名">
      <div class="time-xz">
        <div class="nice-select times" name="nice-select">
          <input type="text" value="开始日期">
          <ul style="display: none;">
            <li>00:00</li>
            <li>00:30</li>
            <li>01:00</li>
            <li>01:30</li>
            <li>02:00</li>
            <li>02:30</li>
            <li>03:00</li>
            <li>03:30</li>
          </ul>
        </div>
        <div class="nice-select times" name="nice-select">
          <input type="text" value="结束日期">
          <ul style="display: none;">
            <li>00:00</li>
            <li>00:30</li>
            <li>01:00</li>
            <li>01:30</li>
            <li>02:00</li>
            <li>02:30</li>
            <li>03:00</li>
            <li>03:30</li>
          </ul>
        </div>
        <div class="nice-select times" name="nice-select">
          <input type="text" value="在岗">
          <ul style="display: none;">
            <li>在岗</li>
            <li>离职</li>
          </ul>
        </div>
      </div>
      <input type="text" value="搜索" class="sech_1">
    </li>
  </ul>

  <dl class="jz_tab">
    <dt>
      <div class="jz_tab_1">兼职人员</div>
      <div class="jz_tab_2">当前工作地点</div>
      <div class="jz_tab_3">上岗天数</div>
      <div class="jz_tab_4">工作记录</div>
      <div class="jz_tab_5">操作</div>
    </dt>
<?php foreach ($models as $applicant) {
    $resume = $applicant->resume;
    $address = $applicant->address;
    $s = null;
    if (isset($summaries[$applicant->user_id])){
        $s = $summaries[$applicant->user_id];
    }
?>
    <dd>
      <div class="jz_tab_1"><a href="#"><?=$resume->name?></a></div>
      <div class="jz_tab_2"><?=$address?$address->title:'无'?></div>
      <div class="jz_tab_3"><?=$s?$s->count:0?>天</div>
      <div class="jz_tab_4">
        <?php if($s){ ?>
            <span>迟到<em><?=$s->on_late_count?></em></span>
            <span>早退<em><?=$s->off_early_count?></em></span>
            <span>旷工<em class="red"><?=$s->out_work_count?></em></span>
            <span>记录<em><?=$s->noted_count?></em></span></div>
        <?php } else { ?>
            <span>无记录</span>
        <?php }?>
      </div>
      <div class="jz_tab_5">
        <div class="box_t">
            <span><a target="_blank" href="/time-book/settings?user_id=<?=$resume->user_id?>&task_id=<?=$task->id?>">工作内容设置</a></span>
            <span><a target="_blank" href="/time-book/detail?user_id=<?=$resume->user_id?>&task_id=<?=$task->id?>">工作明细</a></span>
    </div>
    </dd>
<?php } ?>
  </dl>
<div class="daka_foot">
<?=LinkPager::widget(['pagination' => $pages,
    'maxButtonCount'=>5,
    'lastPageLabel'=>'末页', 'nextPageLabel'=>'>>',
    'prevPageLabel'=>'<<', 'firstPageLabel'=>'首页'])?>

    <div class="daka_r">
      <a href="#" class="xiazai">下载考勤表</a>
      <a href="/time-book/add?gid=<?=$task->gid?>">添加兼职人员</a>
    </div>
</div>

