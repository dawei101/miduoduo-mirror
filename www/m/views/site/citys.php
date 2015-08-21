<?php
use common\Seo;
use common\Utils;

/* @var $this yii\web\View */
$this->title = '首页';
$this->nav_left_link = 'javascript:window.history.back()';
$this->nav_right_link = '/user';
$this->nav_right_title = '个人中心';
$this->nav_left_title = '';

/********* seo start ***********/
$seocity    = isset($city->name)?$city->name:'';
$block      = '';
$type       = '';
$clearance_type = '';
$conpany    = '';
$task_title = '';
$page_type  = 'index';

$seo_code   = Seo::makeSeoCode($seocity,$block,$type,$clearance_type,$conpany,$task_title,$page_type);
/********* seo end ***********/

$this->page_title = $seo_code['title'];
$this->page_keywords = $seo_code['keywords'];
$this->page_description = $seo_code['description'];

?>



<?php $this->beginBlock('css') ?>

<style>
.city .sech{width:100%; padding:10px 0; background:#fff;}
.city dd{clear:both;}
.city .sech input{width:90%; padding:3% 0; margin:0 auto; display:block; border:1px #eee solid; border-radius:40px; text-indent:3em; color:#999; font-size:1em; background:url(img/sech.png) 3% no-repeat #fff; }
.current_city{width:100%; padding:3% 0; background:#fff; text-align:left; line-height:30px; margin:2% 0; font-size:1em; color:#666;}
.current_city div{width:90%; margin:0 auto;}
.current_city span{color:#00b966;}
.city_title{width:90%; margin:0 auto 2%; color:#a5abb2; font-weight:600;}
.city_title1{width:95%; margin:3% auto 2%; color:#a5abb2; font-weight:600;}
.tag_re,.tag_more,.tag_list{width:100%; margin:0 auto; overflow:hidden;}
.tag_re a{display:block; width:31%; padding:2% 0; text-align:center; color:#2a3141; float:left; margin-left:2%; background:#fff; border-radius:4px; margin-bottom:2%}
.tag_more a{display:block; width:18%; padding:2% 0; text-align:center; color:#2a3141; float:left; margin-left:2%; background:#fff; border-radius:4px; margin-bottom:2%}
.tag_re a:hover,.tag_more a:hover,.tag_list a:hover{background:#00b966; color:#fff;}
.tag_list a{padding:2% 0 2% 8%; width:92%; display:block; border-bottom:1px #d0d0d0 solid;color:#2a3141;}
.pinyin:target{
    padding-top:48px;
}
.search_city{
    width:100%; padding:3% 0; background:#fff; text-align:left; line-height:30px; font-size:1em; color:#666;
}
.search_city a{
    border-bottom: 1px solid #eeeeee;
    display: block;
    margin: 0 5%;
    padding: 1% 8%;
    color: #666;
}
</style>
<!--======固定顶部======-->

<dl class="city">
   <dt class="sech"><input name="" id="search-city" type="text" placeholder="输入城市名或首字母查询"></dt>
   <dd class="search_city" style="display:none;"></dd>
   <dd class="current_city"><div>当前定位城市：<span>北京</span></div></dd>
   <dd>
       <div class="city_title">热门城市</div>
       <div class="tag_re">
           <?php foreach($citys as $city){ ?>
               <?php if($city->is_hot==1){ ?>
                   <a href="/<?=$city->seo_pinyin?>/"><?=$city->name?></a>
               <?php } ?>
           <?php } ?>
       </div>
   </dd>
   <dd>
       <div class="city_title">更多城市</div>
       <div class="tag_more">
           <?php foreach($pinyins as $pinyin){ ?>
               <a href="#pinyin_<?=$pinyin?>"><?=$pinyin?></a>
           <?php } ?>
       </div>
   </dd>
   <dd> 
        <?php foreach($pinyins as $pinyin){ ?>
            <dl id="pinyin_<?=$pinyin?>" class="pinyin">
                <dt class="city_title1"><?=$pinyin?></dt>
                <dd class="tag_list">
                    <?php foreach($citys as $city){ ?>
                        <?php if( substr($city->seo_pinyin,0,1)==strtolower($pinyin) ){ ?>
                            <a href="/<?=$city->seo_pinyin?>/"><?=$city->name?></a>
                        <?php } ?>
                    <?php } ?>
                </dd>
            <dl>
        <?php } ?>
   </dd>
</dl>

<?php $this->beginBlock('js') ?>
<script src="<?=Yii::$app->params["baseurl.static.m"]?>/static/js/bxslider.js"></script>
<script>
    $(document).ready(function(){
        var citys_json = <?=$citys_json?>;
        $("#search-city").on('keyup',function(){
            var keyword = $(this).val();
            if(keyword.length > 0){
                var search_city = '';
                var p_limit = 4;
                var p_num   = 0;
                $.each(citys_json, function(i, v) {
                    if (v.name.search(keyword) > -1) {
                        search_city += '<a href="/'+v.seo_pinyin+'/">'+v.name+'</a>';
                        p_num ++;
                    }
                    if(p_num > p_limit){
                        return false;
                    }
                });
                //alert(search_city.length);
                if( search_city.length > 0 ){
                    $(".search_city").html(search_city);
                    $(".search_city").show();
                }else{
                    $(".search_city").html('');
                    $(".search_city").hide();
                }

            }
        });
    });
</script>
<?php $this->endBlock('js') ?>