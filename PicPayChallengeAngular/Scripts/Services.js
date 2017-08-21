angular.module('mainApp')
    .factory('userService', function ($resource) {
        var odataUrl = '/api/Users?';
        return $resource('', {},
            {
                'getAll': { method: 'GET', url: odataUrl },
                'getStart': { method: 'GET', url: odataUrl + '$orderby=Priority' },                                  
                'filterData': { method: 'GET', params: { filter: '@filter' }, url: odataUrl + ':filter' },                
                'nextLink': { method: 'GET', params: { nextPage: '@nextPage' }, url: odataUrl + ':nextPage' },
                'previousLink': { method: 'GET', params: { previousPage: '@previousPage' }, url: odataUrl + ':previousPage' }
            }
        );
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