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
  <link rel="shortcut icon"  href="/img/miduoduo.ico" />
  <link href="/css/font/iconfont.css" type="text/css"  rel="stylesheet" >
  <link href="/css/mdd.css" type="text/css"  rel="stylesheet" >

  <script src="/js/angularjs-v1.4.2/angular.js"></script>
  <script src="/js/fastclick.js"></script>
  <script src="/controller.js"></script>
</head>
<body>
<div ng-controller="TaskC">
    {{data.title}}
    <p> {{data.detail}} </p>
</div>
</body>
</html>
