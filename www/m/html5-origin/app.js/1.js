var mApp = angular.module('mApp', []);
var getUrl = function(uri){
    return 'http://api.test.chongdd.cn/v1' + uri;
}

mApp.controller('TaskListC', function ($scope, $http) {
  $scope.get(getUrl('/task')).success(fucntion(data){
    $scope.tasks = data.items;
  });
});
