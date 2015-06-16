
var baseurl = 'http://192.168.1.20:9996';
var access_token = 'pmYaSdsWhqU4tvjHoV4SY3ZLEtXUBwEX_1434423867';
var version = 'v1';
function getUrl(s){ return baseurl + '/' +  version + s + '?access_token=' + access_token; }


var app = angular.module('miduoduoApp', ['ngRoute']);

app.controller('TaskListController', ['$scope', '$http' , function ($scope, $http){

    $scope.getTasks = function (page){
        var url = page==undefined?getUrl('/task'):(getUrl('/task')+'?page='+page);
        $http.get(url, function(data){
            $scope.tasks = data.items;
            $scope.pagination = data._meta;
        });
    };

    $scope.nextPage = function(){
        $scope.hasNextPage()?$scope.getTask($scope.pagination.currentPage+1):'';
    };
    $scope.hasNextPage = function(){
        return $scope.pagination.pageCount>$scope.pagination.currentPage;
    };
    $scope.getTasks();
}]);

app.config(function($resourceProvider) {
      $resourceProvider.defaults.stripTrailingSlashes = true;
});

