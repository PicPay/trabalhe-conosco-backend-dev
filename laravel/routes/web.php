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

Route::get('/',  'Auth\LoginController@showLogin');


// route to show the login form
Route::get('login', 'Auth\LoginController@showLogin');
Route::post('checklogin', 'Auth\LoginController@checklogin');
Route::get('dashboard', 'Auth\LoginController@dashboard');
Route::get('logout', 'Auth\LoginController@logout');


Route::group([
    'prefix' => 'list',
], function () {
    Route::post('get_list', 'ListController@getList');
    Route::get('list_management', 'ListController@index');


    Route::post('delete_first_list', 'ListController@removeFromPrimaryList');
    Route::post('delete_secondary_list', 'ListController@removeFromSecondaryList');
});

Route::group([
    'prefix' => 'search',
], function(){
Route::get('search_user', 'SearchController@index');
Route::post('search_user', 'SearchController@getCustomer');
});
