var app = angular.module("DemoApp", ['ngMaterial', 'cl.paging']);
app.controller("MainController", ['$scope', function($scope) {

  $scope.currentPage = 0;

  $scope.paging = {
    total: 100,
    current: 1,
    onPageChanged: loadPages,
  };

  function loadPages() {
    console.log('Current page is : ' + $scope.paging.current);

   alert($scope.paging.current);

    $scope.currentPage = $scope.paging.current;
  }

}]);