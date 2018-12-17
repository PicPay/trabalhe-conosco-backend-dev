var app =  angular.module('main-App',['ngRoute','angularUtils.directives.dirPagination']);
app.config(['$routeProvider',
    function($routeProvider) {
        $routeProvider.
            when('/items-list', {
                templateUrl: 'templates/items.html',
                controller: 'ItemController'
            });
}]);