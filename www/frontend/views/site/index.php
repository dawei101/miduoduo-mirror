<?php
/* @var $this yii\web\View */
$this->title = '米多多兼职平台';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<link     rel="shortcut icon"  href="img/miduoduo.ico" />
<title>米多多/兼职平台</title>
<link href="css/miduoduo.css" type="text/css" rel="stylesheet" >
</head>
<body>
<div class="top">
  <div class="toumin-box"></div>
  <div class="top-center">
    <nav>
      <div class="logo"><img src="img/logo.png" width="200" height="110"></div>
      <!-- <div class="nav"><a href="/site/Contact/"  class="contact-us">联系我们</a><a href="#">企业合作</a></div> -->
    </nav>
    <div class="banner"><img src="img/banner.png" width="751" height="407">
      <h1>米多多 | 大学生兼职平台</h1>
      <div class="erweima"><img src="img/erweima.png" width="140" height="140">
        <p>扫码进入m站</p>
      </div>
    </div>
  </div>
</div>
<div class="miduoduo-one">
  <div class="miduoduo-ms">
    <div class="y-ability"><img src="img/ablility-icon.png" width="75" height="80"><span>我的能力</span></div>
    <div class="jia1">+</div>
    <div class="y-Interest"><img src="img/Interest-icon.png" width="75" height="80"><span>我的兴趣</span></div>
    <div class="jia2">+</div>
    <div class="y-time"><img src="img/time-icon.png" width="75" height="80"><span>我的时间</span></div>
    <div class="deng">=</div>
    <div class="y-miduoduo"><img src="img/logo1.png" width="150" height="60"><span>我的兼职工作</span></div>
  </div>
</div>
<div class="position-type-box">
  <ul>
    <li class="orange">派单员</li>
    <li class="blue">会展</li>
    <li class="light-green">模特</li>
    <li class="dark-red">舞蹈教练</li>
    <li class="orange">翻译</li>
    <li class="blue">视频</li>
    <li class="light-green">产品</li>
    <li class="dark-red">运营</li>
    <li class="orange">SEO</li>
    <li class="blue">家教</li>
    <li class="light-green">CAD</li>
    <li class="light-blue">平面</li>
    <li class="blue">程序</li>
    <li class="light-blue">运维</li>
    <li class="blue">促销</li>
    <li class="light-green">美工</li>
    <li class="dark-red">法律</li>
    <li class="blue">高薪服务员</li>
  </ul>
</div>
<div class="service"> <span>米多多</span>
  <p>我们能为您做到那些？</p>
</div>
<div class="function-display" >
  <ul id="suc1">
    <li>
      <img src="img/function-pic.jpg" width="330" height="330">
      <div class="text"><img src="img/free-icon.png" width="71" height="32"><p>完全免费</p></div>
    </li>
     <li>
     <img src="img/function-pic1.jpg" width="330" height="330">
<div class="text"><img src="img/xing.png" width="96" height="29"><p>一流合作企业</p></div>
    </li>
     <li>
     <img src="img/function-pic2.jpg" width="330" height="330">
<div class="text"><img src="img/gaoxin.png" width="39" height="42"><p>众多高薪职位</p></div>
    </li>
     <li>
      <img src="img/function-pic3.jpg" width="330" height="330">
<div class="text"><img src="img/anquan.png" width="41" height="46"><p>安全担保</p></div>
    </li>
     <li>
     <img src="img/function-pic4.jpg" width="330" height="330">
<div class="text"><img src="img/lignhuo.png" width="38" height="38"><p>时间灵活</p></div>
    </li>
     <li>
     <img src="img/function-pic5.jpg" width="330" height="330">
<div class="text"><img src="img/jiujin.png" width="43" height="41"><p>就近择业</p></div>
    </li>
  </ul>
</div>

<div class="bottom-bsnner">
    <div class="toumin-box"></div>
    <div class="text-mi">米多多，不仅仅是兼职！</div>
</div>


<footer>
     <ul>
        <li class="contact-us1">
            <h2>联系我们</h2>
            <p>邮箱：coutact@miduoduo.cn</p>
            <p>电话：010-84991662</p>
        </li>
        <li class="about-us">
            <h2>关于我们</h2>
            <p><a href="#">公司介绍</a></p>
            <p><a href="#">团队介绍</a></p>
        </li>
        <li class="xian"></li>
        <li class="attention-us">
            <h2>关注我们</h2>
            <div class="erwei"><img src="img/fooerwei.jpg" width="70" height="70"><div class="er-text">扫码进入m站</div></div>
            <!-- <div class="erwei"><img src="img/fooerwei1.jpg" width="70" height="70"><div class="er-text">关注微信公众号</div></div>-->
       </li>
     </ul>
</footer>

<script src="js/jquery.min.js"></script> 
<script>
    $(function(){
        $(function(){
        $('#suc1 li').hover(function(){
            $('.text',this).stop().animate({
                height:'0'
            });
        },function(){
            $('.text',this).stop().animate({
                height:'330px'
            });
        });
    });
    })
</script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
  ga('create', 'UA-64201170-1', 'auto');
  ga('send', 'pageview');
</script>
<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "//hm.baidu.com/hm.js?71fce0b5ae66cac6b8ba9fc072998791";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>
</body>
</html>
