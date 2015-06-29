var mApp = angular.module('mApp', []);

var access_token = 'jKCBEcA-fS0mKmG31iqBycSFZuLaJNjC_1435318132';
var getApiUrl = function(uri){
    return 'http://api.test.chongdd.cn/v1' + uri + '?access_token=' + access_token;
}
var getUrl = function(uri){
    return uri;
}


mApp.controller('TaskListC', ['$scope', '$http',
  function ($scope, $http) {
    function query(url){
        $http.get(url).success(function(data) {
            $scope.data= data;
        });
    }
    $scope.nextPage = function(){
        console.info($scope);
        query($scope.data._links.next.href);
    }

    $scope.lastPage = function(){
        query($scope.data._links.last.href);
    }

    $scope.detail = function(record){
        location.href = getUrl('/task/view?id=' + record.gid);
    }

    query(getApiUrl('/task'));
}]);

mApp.controller('TaskC', ['$scope', '$http',
  function ($scope, $http) {
    function query(url){
        $http.get(url).success(function(data) {
            $scope.data= data;
        });
    }
    query(getApiUrl('/task'));
}]);
