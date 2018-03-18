

var app = angular.module('usuarios', ['angularUtils.directives.dirPagination']);


app.controller('UsuariosController', function($scope, $http) {
	
	$scope.ini = 1;
	$scope.fim = 15;
	
	$scope.loading = false;
	$scope.buscar = function () {
		$scope.loading = true;
		$scope.users = [];
		
		$http.get("/usuarios/"+ $scope.busca +"/"+ $scope.ini  +"/" + $scope.fim, { cache: true}).then(function (response) {
	
			$scope.loading = false;
			angular.forEach(response.data, function (item){
					$scope.users.push(item);
			});
		});
	};
});
