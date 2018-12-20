<?php

use Illuminate\Http\Request;
use App\CustomerController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'prefix' => 'auth'
], function () {

    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');

    Route::group([
        'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', 'Auth\AuthController@logout');
        Route::get('user', 'Auth\AuthController@user');
    });
});


Route::middleware('auth:api')
    ->get('user', 'Auth\AuthController@user');

Route::group([
    'prefix' => 'rest',
    'middleware' => 'auth:api'
], function () {
    Route::post('customer', 'API\CustomerController@getCustomer');
});

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
