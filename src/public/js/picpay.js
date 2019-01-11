'use strict';
var app = angular.module('picpay',[]);

app.config(function($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
  });

// Service
app.factory('usersService',function($http) {
	return {
		lista: function(){
			return $http.get('/apiPicpay/users');
		},
		cadastra: function(data){
			return $http.post('/apiPicpay/users', data);
		},
		edita: function(data){
			var id = data.id;
            //delete data.id;
			return $http.put('/apiPicpay/users/'+id, data);
		},
		exclui: function(id){
			return $http.delete('/apiPicpay/users/'+id)
        },
        busca: function(page,query){
			return $http.get('/apiPicpay/users?page='+page+'&q='+query);
		}
	}
});

// Controller
app.controller('usersController', function($scope, usersService, $compile) {
    $scope.user = {};
    //$('#userModal').modal();
	$scope.listar = function(){
        $('.loading').show();
        $('.dados').hide();
		usersService.lista().then(function(data){
            console.log(data);
            $scope.users = data.data.data;
            montarPaginacao(data);
            $('.loading').hide();
            $('.dados').show();
		},function(res){
            console.log(res);
            alert('Erro ao buscar usuários!');
        });
	}

	$scope.editar = function(data){
        $scope.user = data;
		$('#userModal').modal('show');
	}

	$scope.salvar = function(){
        console.log('Usuario para salvar.');
        console.log($scope.user);
		if($scope.user.id){
			usersService.edita($scope.user).then(function(res){
				//$scope.listar();
			},function(res){
                alert(res.data.message);
			});
		}else{
			usersService.cadastra($scope.user).then(function(res){
				//$scope.listar();
			},function(res){
                alert(res.data.message);
			});
        }
        $('#userModal').modal('hide');
        $scope.user = {};
	}

	$scope.excluir = function(data){
		if(confirm("Tem certeza que deseja excluir?")){
			usersService.exclui(data.id).then(function(res){
                //$scope.listar();
                var index = $scope.users.indexOf(data);
                $scope.users.splice(index, 1);
            },function(res){
                console.log('Error ao exluir usuario');
                console.log(res);
                alert(res.data.message);
            });


		}
    }

    $scope.buscar = function(page,query){
        $('.loading').show();
        $('.dados').hide();
        query = typeof $scope.pesquisar === 'undefined' ? null : $scope.pesquisar;
        console.log('Buscando...');
        console.log('Pagina: ' +page);
        console.log('Query: ' +query);
		usersService.busca(page,query).then(function(data){
            console.log(data);
            console.log("Pagina Atual: " +data.data.current_page);
            $scope.users = data.data.data;
            montarPaginacao(data);
            $('.loading').hide();
            $('.dados').show();
		},function(res){
            console.log(res);
            alert('Erro ao buscar usuários!');
        });
    }

    function montarPaginacao(data)
    {
        $("#paginacao li").remove();
        var limitItems = 10;
        var count = 0;
        var minDivisor = data.data.current_page;
        while(minDivisor != 0)
        {
            if(minDivisor % limitItems === 0)
            {
                count = minDivisor-1;
                limitItems++;
                break;
            }
            minDivisor--;
        }
        var delimiter = count + limitItems;

        if(count == 0)
        {
            count = 1;
        }
        var query = typeof $scope.pesquisar === 'undefined' ? null : $scope.pesquisar;

        if(data.data.current_page == 1)
        {
            $("#paginacao").append('<li aria-disabled="true" aria-label="« Anterior" class="page-item disabled"><span aria-hidden="true" class="page-link">‹</span></li>');
        }
        else
        {
            var prevPage = data.data.current_page-1;
            $("#paginacao").append('<li class="page-item"><span ng-click="buscar('+prevPage+','+query+')" rel="prev" aria-label="« Anterior" class="page-link">‹</span></li>')
        }

        for(var i=count; i<=delimiter; i++)
        {
            if(i <= data.data.last_page)
            {
                if(i == data.data.current_page )
                {
                    $("#paginacao").append('<li aria-current="page" class="page-item active"><span class="page-link">'+i+'</span></li>');
                }
                else
                {
                    $("#paginacao").append('<li class="page-item"><span ng-click="buscar('+i+','+query+')" class="page-link">'+i+'</span></li>');
                }
                count++;
            }

        }
        if(data.data.current_page == data.data.last_page)
        {
            $("#paginacao").append('<li aria-disabled="true" aria-label="Próxima »" class="page-item disabled"><span aria-hidden="true" class="page-link">›</span></li>');
        }
        else
        {
            var nextPage = data.data.current_page+1;
            $("#paginacao").append('<li class="page-item"><span ng-click="buscar('+nextPage+','+query+')" rel="next" aria-label="Próxima »" class="page-link">›</span></li>');
        }
        $('#totalPage').text('Total de paginas: ' +data.data.last_page);
        $('#totalItens').text('Foram encontrados ' +data.data.total+' registros.');
        $compile($("#paginacao"))($scope);
    }
});
