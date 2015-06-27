var mApp = angular.module('mApp', []);

var access_token = 'jKCBEcA-fS0mKmG31iqBycSFZuLaJNjC_1435318132';
var getUrl = function(uri){
    return 'http://api.test.chongdd.cn/v1' + uri + '?access_token=' + access_token;
}
mApp.controller('TaskListC', ['$scope', '$http',
  function ($scope, $http) {
    $http.get(getUrl('/task')).success(function(data) {
        $scope.tasks = data.items;
    });

    $scope.orderProp = 'age';
}]);
