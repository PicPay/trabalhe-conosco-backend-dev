/// <reference path="angular.js" />
angular.module('mainApp', ['ngResource', 'chieffancypants.loadingBar'])
    .config(['$httpProvider', function ($httpProvider) {
        $httpProvider.defaults.headers.patch = {
            'Content-Type': 'application/json;charset=utf-8'
        }
    }]);
