/**
*全局常量配置
* header
* footer
*/
/*
数据初始化
 */
var miduoduo = {};
    miduoduo.vars = {};
var aa = angular.module("app",[]);
aa.directive("hello",function(){
    return{
        restrict:'E',
        scope : {
            title : "=",
            content : "=",
            ip : "="
        },
        templateUrl : function(p1,p2) {
            console.log(arguments);
            return  "/miduoduo/www/m/web/page/test.html";
        },
        controller : "cc",
        link : function(scope, iElement, iAttrs) {
            console.log(iAttrs);
            console.log(iElement.html())
            var a = iElement.html();
            var p = iElement.parent();
            iElement.remove();
            p.append(a);
        }
    };
})

aa.controller("cc", function($scope) {
    $scope.mm = 12;
})