<?php

?>
<div class="body-box">
<div class="midd-kong"></div>
<div class="container">
  <div class="row">
    <div class="fabu-box padding-0">
      <div class="col-sm-12 col-md-2 col-lg-2 padding-0" style="background:#f00">
        <?= $this->render('../layouts/sidebar', ['active_menu'=> 'time_book'])?>
      </div>
      <div class="col-sm-12 col-md-10 col-lg-10 padding-0 ">
        <div class="right-center">
          <div class="conter-title1">考勤管理 &gt; 汽车之家APP推广 &gt; 添加日程安排 </div>
          <ul class="tianxie-box" style="border:none">
            <li>
              <div class="pull-left title-left text-center">兼职人员</div>
              <div class="pull-left right-box jz_renyuan jz_in">
                <input type="text" class="input_t" placeholder="从已报名兼职库里选兼职人员">
                <div class="jz_name">
                    <?php foreach ($task->resumes as $resume ) {?>
                    <span><?=$resume->name?></span>
                    <?php } ?>
                    <div class="jz_ry_qd"><button>确定</button></div>
                </div>
               </div>
            </li>
            <li>
                  <div class="pull-left title-left text-center">工作时间</div>
                  <div class="pull-left right-box div">
                    <div class="riqi jz_in">
                      <input type="text" readonly="" style="width: 330px" name="reservation" class="reservation" value="选择您的工作起始日期">
                  </div>
                 
                  <p class="cuowu">内容不能为空!</p>
                </div></li>
            <li>
              <div class="pull-left title-left text-center">工作地点</div>
              <div class="pull-left right-box zhiweileibie">
                <div class="nice-select jz_in" name="nice-select">
                  <input type="text" placeholder="地点">
                  <ul class="in500">
                    <?php foreach ($task->addresses as $address) { ?>
                    <li data-value="<?=$address->id?>"><?=$address->title . '(' . $address->address . ')'?></li>
                    <?php }?>
                  </ul>
                </div>
              </div>
            </li>
            <li>
              <div class="pull-left title-left text-center">打卡地点</div>
              <div class="pull-left right-box jz_in">
                 <input type="text" placeholder="输入搜索打卡坐标">
                 <p class="map_ts">*拖动地图图标可更改打卡地点</p>
                 <div class="map_box"><div width="500" height="312"></div></div>
              </div>
            </li>
            <li>
              <div class="pull-left title-left text-center">上下班时间</div> 
              <div class="time-xz">
                      <div class="nice-select times" name="nice-select">
                        <input type="text" placeholder="上班时间" value="<?=$task->from_time?>">
                        <ul>
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
                      <span class="pull-left">至</span>
                      <div class="nice-select times" name="nice-select">
                        <input type="text" placeholder="下班时间" value="<?=$task->to_time?>">
                        <ul>
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
                  </div>
            </li>
          <button class="queding-bt">提交</button>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $this->beginBlock('js') ?>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=<?=Yii::$app->params['baidu.map.web_key']?>"></script>
<script type="text/javascript">
    // 百度地图API功能
    var map = new BMap.Map("map");            // 创建Map实例
    map.centerAndZoom(new BMap.Point(116.4035,39.915),8);  //初始化时，即可设置中心点和地图缩放级别。
    map.enableScrollWheelZoom(true);
    map.disableDragging();     //禁止拖拽
    setTimeout(function(){
       map.enableDragging();   //两秒后开启拖拽
       //map.enableInertialDragging();   //两秒后开启惯性拖拽
    }, 2000);
</script>
<script>
$(".jz_renyuan").on("click","input",function(){
    $(this).next().show();
});
$(".jz_name").on("click","span",function(){
    $(this).toggleClass("span_on");
})
$(".jz_ry_qd").on("click","button",function(){
    $(this).parent().parent().hide();
    var arr = [];
    $(".span_on").each(function() {
        arr.push($(this).text());
    });
    //alert(arr);
    $(".input_t").val(arr.join(","));
});
</script>
<?php $this->endBlock('js') ?>
</div>
