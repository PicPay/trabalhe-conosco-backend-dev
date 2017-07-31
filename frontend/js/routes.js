app.config(function ($routeProvider, $locationProvider) {
  $locationProvider.html5Mode(false); // se true, tira o # da url

  $routeProvider
  // Rota para a Home
      .when('/', {
          templateUrl: 'templates/login.html',
          controller: 'LoginCtrl'
      })

      // Rota para a página About
      .when('/search', {
          templateUrl: 'templates/search.html',
          controller: 'SearchCtrl'
      })

      // Caso não seja nenhum desses,
      // redirecione para a rota '/'
      .otherwise ({ redirectTo: '/' });
});