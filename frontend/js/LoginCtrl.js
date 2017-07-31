app.controller('LoginCtrl', function ($scope, $appLogin) {
    $scope.email = 'teste@orangepixel.com.br';
    $scope.password = 'teste';

    $scope.login = function() {
        $appLogin.login($scope.email, $scope.password);
    };

});