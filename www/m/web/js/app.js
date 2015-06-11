'use strict';

/* App Module */

var resumeApp = angular.module('resumeApp', [
  'ngRoute',
  'phonecatAnimations',
  'resumeControllers',
  'phonecatFilters',
  'phonecatServices'
]);

resumeApp.config(['$routeProvider',
  function($routeProvider) {
    $routeProvider.
      when('/resume/view', {
        templateUrl: 'partials/resume-detail.html',
        controller: 'ResumeDetailCtrl'
      }).
      when('/resume/address', {
        templateUrl: 'partials/edit-address.html',
        controller: 'EditAddressCtrl'
      }).
      otherwise({
        redirectTo: '/resume/view'
      });
  }]);
