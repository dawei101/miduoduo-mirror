define(function(require, exports, module) {
    require("angular");

    var indexApp = angular.module('indexApp', []);
    indexApp.controller('indexCtrl', ['$scope',
        function($scope) {
           console.log($scope);
        }]);
});