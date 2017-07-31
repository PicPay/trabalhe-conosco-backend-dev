var app = angular.module('myApp', ['ngRoute']);

app.constant('$appConfig', {
    urlBase: 'http://' + window.location.hostname + ':8180/api'
});