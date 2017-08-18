var user = angular.module('user', ['ui.router', 'ngAnimate']);
var userCtrl = function(users, $scope, $http, $filter, $timeout) {
  $scope.users = users;
  $scope.sort = {       
    sortingOrder : 'id',
    reverse : false
  };
  $scope.gap = 3;
  $scope.filteredItems = [];
  $scope.groupedItems = [];
  $scope.itemsPerPage = 10;
  $scope.pagedItems = [];
  $scope.currentPage = 0;   
  //pagination functions
  var searchMatch = function (haystack, needle) {
    if (!needle) {
        return true;
    }
    return haystack.toLowerCase().indexOf(needle.toLowerCase()) !== -1;
  };

  $scope.search = function () {
    $scope.filteredItems = $filter('filter')($scope.users, function (item) {
      for(var attr in item) {
        if (searchMatch(item[attr], $scope.query))
          return true;
        }
      return false;
    });
    // take care of the sorting order
    if ($scope.sort.sortingOrder !== '') {
      $scope.filteredItems = $filter('orderBy')($scope.filteredItems, $scope.sort.sortingOrder, $scope.sort.reverse);
    }
    $scope.currentPage = 0;
    // now group by pages
    $scope.groupToPages();
  };
  
  // calculate page in place
  $scope.groupToPages = function () {
    $scope.pagedItems = [];
    for (var i = 0; i < $scope.filteredItems.length; i++) {
      if (i % $scope.itemsPerPage === 0) {
        $scope.pagedItems[Math.floor(i / $scope.itemsPerPage)] = [ $scope.filteredItems[i] ];
      } else {
        $scope.pagedItems[Math.floor(i / $scope.itemsPerPage)].push($scope.filteredItems[i]);
      }
    }
  };
  
  $scope.range = function (size,start, end) {
    var ret = [];        
    if (size < end) {
      end = size;
      start = size-$scope.gap;
    }
    for (var i = start; i < end; i++) {
      ret.push(i);
    }        
    return ret;
  };
  
  $scope.prevPage = function () {
    if ($scope.currentPage > 0) {
        $scope.currentPage--;
    }
  };
  
  $scope.nextPage = function () {
    if ($scope.currentPage < $scope.pagedItems.length - 1) {
        $scope.currentPage++;
    }
  };
  
  $scope.setPage = function () {
    $scope.currentPage = this.n;
  };
  $scope.search();
};
user.directive("customSort", function() {
  return {
    restrict: 'A',
    transclude: true,    
    scope: {
      order: '=',
      sort: '='
    },
    template : 
      ' <a ng-click="sort_by(order)" style="color: #555555;">'+
      '    <span ng-transclude></span>'+
      '    <i ng-class="selectedCls(order)"></i>'+
      '</a>',
    link: function(scope) {
      scope.sort_by = function(newSortingOrder) {       
        var sort = scope.sort;
        if (sort.sortingOrder == newSortingOrder){
          sort.reverse = !sort.reverse;
        }
        sort.sortingOrder = newSortingOrder;        
      };
      scope.selectedCls = function(column) {
        if(column == scope.sort.sortingOrder){
          return ('icon-chevron-' + ((scope.sort.reverse) ? 'down' : 'up'));
        }
        else{            
          return'icon-sort' ;
        } 
      };      
    }
  };
});
user.service('UserService', function($http){
  function getUsers() {
    return $http.get( 'http://localhost:8000/users');
  }
  return {
    getUsers: getUsers
  };
});




