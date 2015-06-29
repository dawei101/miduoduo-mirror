<!doctype html>
<html lang="en" ng-app="mApp">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no">
  <meta http-equiv="pragma" content="no-cache">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta http-equiv="pragma" content="no-cache">
  <meta content="black" name="apple-mobile-web-app-status-bar-style">
  <title>Google Phone Gallery</title>
  <link rel="shortcut icon"  href="img/miduoduo.ico" />
  <link href="/css/font/iconfont.css" type="text/css"  rel="stylesheet" >
  <link href="/css/mdd.css" type="text/css"  rel="stylesheet" >

  <script src="/js/angularjs-v1.4.2/angular.js"></script>
  <script src="/js/fastclick.js"></script>
  <script src="/controller.js"></script>
</head>
<body>
<div ng-controller="TaskListC">



<div class="guding-top">
  <dl class="select">
    <dt>北京市<span class="inverted-triangle"></span></dt>
    <dd>
      <ul>
        <li><a href="#">全城</a></li>
        <li><a href="#">东城区</a></li>
        <li><a href="#">朝阳区</a></li>
        <li><a href="#">丰台区</a></li>
        <li><a href="#">海淀区</a></li>
        <li><a href="#">房山区</a></li>
        <li><a href="#">顺义区</a></li>
        <li><a href="#">昌平区</a></li>
        <li><a href="#">大兴区</a></li>
        <li><a href="#">密云县</a></li>
        <li><a href="#">延庆县</a></li>
        <li><a href="#">西城区</a></li>
        <li><a href="#">通州区</a></li>
        <li><a href="#">怀柔区</a></li>
        <li><a href="#">门头沟区</a></li>
        <li><a href="#">门头沟区q</a></li>
         <li><a href="#">门头沟区qq</a></li>
      </ul>
    </dd>
  </dl>
  <dl class="select">
    <dt>兼职类型<span class="inverted-triangle"></span></dt>
    <dd>
      <ul>
        <li><a href="#">全部</a></li>
        <li><a href="#">传单</a></li>
        <li><a href="#">家教</a></li>
        <li><a href="#">礼仪模特</a></li>
        <li><a href="#">实习生</a></li>
        <li><a href="#">临时工</a></li>
        <li><a href="#">IT</a></li>
        <li><a href="#">会展</a></li>
        <li><a href="#">美工平面</a></li>
        <li><a href="#">服务员</a></li>
        <li><a href="#">翻译</a></li>
        <li><a href="#">教练</a></li>
        <li><a href="#">促销</a></li>
        <li><a href="#">推广</a></li>
        <li><a href="#">客服</a></li>
      </ul>
    </dd>
  </dl>
  <dl class="select" style="border-right:none;">
    <dt>排序<span class="inverted-triangle"></span></dt>
    <dd>
      <ul>
        <li><a href="#">默认</a></li>
      </ul>
    </dd>
  </dl>
</div>
<!--===========以上是筛选==============-->
<div style="height:50px;"></div>

<!--======列表======--> 
<a class="list" ng-click="detail(task)" ng-repeat="task in data.items">
<div class="list-title">
  <h2>{{task.title}}</h2><span>06-16</span>
</div>
<div class="list-tag"><span class="tag-im">120元/天</span><span>日结</span><span>朝阳</span></div>
</a>
<div class="page">
   <a ng-click="lastPage()"><span class="arrow-left"></span>上一页</a>
   <a ng-click="nextPage()">下一页<span class="arrow-right"></span></a>
</div>
</div>
</body>
</html>
