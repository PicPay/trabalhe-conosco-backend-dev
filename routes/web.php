<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'HomeController@index')->name('home');
Route::get('pesquisar', 'SistemaController@pesquisarTermo');

Route::group(array('prefix' => 'api'), function()
{
  Route::get('busca/{query}/{page}',"SistemaController@search");  
});
