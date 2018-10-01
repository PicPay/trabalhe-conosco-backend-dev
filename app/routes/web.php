<?php

$router->get('/', function () use ($router) {
	return $router->app->version();
});

Route::post('/auth/login', 'AuthController@authenticate');
Route::get('api/users/prioritize', 'UserController@prioritize');

Route::group(['prefix' => 'api/users', 'middleware' => 'jwt.auth'], function () {
	Route::get('/', 'UserController@index');
});

