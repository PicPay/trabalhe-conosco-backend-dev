app.factory('$appLogin', function($appConfig, $localStorage, $http) {
  return {
    login: function(email, password) {
        $localStorage.set('token', '');

        $http({
            method: 'POST',
            url: $appConfig.urlBase + '/authenticate',
            data: {
                'email': email,
                'password': password,
            }
        }).then(function successCallback(response) {
            console.log(response);
            $localStorage.set('token',response.data.token);
            window.location='#/search';
        }, function errorCallback(response) {
            if(response.status == 401) {
                $scope.alerta = 'Login e/ou senha incorretos';
            } else {
                $scope.alerta = 'Ooooppppssss, ocorreu algum erro muito doido. Verifique o console.';
            }
            console.log('erro ao fazer login: ', response);
        });
    },

    logout: function() {
        $http({
            method: 'POST',
            url: $appConfig.urlBase + '/logout',
        }).then(function successCallback(response) {

        }, function errorCallback(response) {
            console.log('logout error: ', response);
        });

        $localStorage.set('token', '');
        window.location='#/login';
    }
  }
});