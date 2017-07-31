app.controller('SearchCtrl', function ($scope, $appConfig, $appLogin, $localStorage, $http, $window) {
    if($localStorage.get('token') == undefined) {
        $appLogin.logout();
    }

    $scope.logout = function() {
        $appLogin.logout();
    };

    $scope.key = '';

    $scope.dados = '';

    $scope.search = function() {
        search($appConfig.urlBase + '/search?key='+$scope.key);
    };

    $scope.prevPage = function() {
        console.log($scope.dados.result.prev_page_url);
        if($scope.dados.result.prev_page_url) {
            search($scope.dados.result.prev_page_url+'&key='+$scope.key);
        }
    };

    $scope.nextPage = function() {
        console.log($scope.dados.result.next_page_url);
        if($scope.dados.result.next_page_url) {
            search($scope.dados.result.next_page_url+'&key='+$scope.key);
        }
    };

    function search(url) {
        $scope.dados = '';
        $http({
            method: 'GET',
            url: url,
            headers: {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer '+$localStorage.get('token')
            },
        }).then(function successCallback(response) {
            $scope.dados = response.data;
            console.log('sucesso: ', $scope.dados);
        }, function errorCallback(response) {
            if(response.status == 400) {
                $window.alert('Seu token expirou, você será redirecionado para a tela de login.');
                $appLogin.logout();
            } else {
                $window.alert('Ops! Ocorreu um erro inesperado, verifique o console log.');
            }
            console.log('erro: ',response);
        });
    }

});