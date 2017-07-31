app.controller('SearchCtrl', function ($scope, $appConfig, $appLogin, $localStorage, $http, $window) {

    if($localStorage.get('token') == undefined) {
        $appLogin.logout();
    }

    $scope.logout = function() {
        $appLogin.logout();
    };

    $scope.key = 'ana';

    $scope.dados = '';

    $scope.buscando = false;

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
        $scope.buscando = true;
        $http({
            method: 'GET',
            url: url,
            headers: {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer '+$localStorage.get('token')
            },
        }).then(function successCallback(response) {
            $scope.dados = response.data;
            $scope.buscando = false;
            console.log('sucesso: ', $scope.dados);
        }, function errorCallback(response) {
            if(response.status == 400) {
                console.log('token expirado');
                $window.alert('Seu token expirou, você será redirecionado para a tela de login.');
                $appLogin.logout();
            } if(response.status == 422) {
                //$window.alert('Ops');
                var msg = response.data[0];
                $window.alert(msg);
                console.log('aguarde o fim da migração de dados');
            } else {
                console.log('Ops! Ocorreu um erro inesperado, verifique o console log.')
                $window.alert('Ops! Ocorreu um erro inesperado, verifique o console log.');
            }
            //console.log('erro: ',response);
            $scope.buscando = false;
        });
        
    }

});