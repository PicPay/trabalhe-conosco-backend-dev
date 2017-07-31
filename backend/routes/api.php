<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

// rotas de login
//Route::post('login', 'ApiLoginController@login')->name('login');
Route::post('authenticate', 'ApiLoginController@authenticate')->name('authenticate');
Route::post('refresh', 'ApiLoginController@refresh')->name('refresh')->middleware(['jwt.auth']);
Route::post('logout', 'ApiLoginController@logout')->name('logout');
Route::get('search', 'ApiSearchController@search')->name('search')->middleware(['jwt.auth']);