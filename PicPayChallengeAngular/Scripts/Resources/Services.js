angular.module('mainApp')
    .factory('userService', function ($resource) {
        var odataUrl = '/api/Users';
        return $resource('', {},
            {
                'getAll': { method: 'GET', url: odataUrl },
                'getStart': { method: 'GET', url: odataUrl + '?$orderby=Priority' },                                  
                'filterData': { method: 'GET', params: { criteria: '@criteria', filter: '@filter' }, url: odataUrl + '?$orderby=Priority&$filter=startswith(:criteria%2C%27:filter%27)eq%20true' }                
            });
    }).factory('notificationFactory', function () {
        return {
            success: function (text) {
                toastr.success(text, "Success");
            },
            error: function (text) {
                toastr.error(text, "Error");
            }
        };
    })