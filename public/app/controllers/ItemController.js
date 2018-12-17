app.controller('AdminController', function($scope,$http){

    $scope.pools = [];

});

app.controller('ItemController', function(dataFactory,$scope,$http){
    $scope.data = [];
    $scope.libraryTemp = {};
    $scope.totalItemsTemp = {};
    $scope.token = $('#token-user').val();

    $scope.totalItems = 0;
    $scope.pageChanged = function(newPage) {
        getResultsPage(newPage);
    };

    getResultsPage(1);
    function getResultsPage(pageNumber) {
        if(! $.isEmptyObject($scope.libraryTemp)){
            dataFactory.httpRequest('/api/items?search='+$scope.searchText+'&page='+pageNumber, $scope.token).then(function(data) {
                $scope.data = data.data;
                $scope.totalItems = data.total;
            });
        }else{
            dataFactory.httpRequest('/api/items?page='+pageNumber, $scope.token).then(function(data) {
                $scope.data = data.data;
                $scope.totalItems = data.total;
            });
        }
    }

    $scope.searchDB = function(){
        if($scope.searchText.length >= 3){
            if($.isEmptyObject($scope.libraryTemp)){
                $scope.libraryTemp = $scope.data;
                $scope.totalItemsTemp = $scope.totalItems;
                $scope.data = {};
            }
            getResultsPage(1);
        }else{
            if(! $.isEmptyObject($scope.libraryTemp)){
                $scope.data = $scope.libraryTemp ;
                $scope.totalItems = $scope.totalItemsTemp;
                $scope.libraryTemp = {};
            }
        }
    }

});