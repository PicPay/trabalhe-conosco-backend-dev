<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
//    return 'API RESTFUL - <a href="https://www.picpay.com/" rel="nofollow"><span>https</span><span>://</span><span>PicPay</span><span>.</span><span>com</span></a>';
    return view('quote', ['quote' => 'teste']);
});


$router->group(['prefix' => 'api/v1'], function () use ($router) {

    $router->get('user/elasticSearch/','UsuariosController@getUserSearch');

    $router->get('user/mysql/','UsuariosController@getUserMysql');

});