<?php
set_time_limit(0);
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

Route::post("/login", ['as' => 'user.login', 'uses' => "HomeController@login" ]);

Route::middleware(['auth'])->group(function () {
    Route::get('/', function () { return view('home'); });
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get("/userspicpay", 'UsersPicpayController@index');
    Route::get("/search", 'UsersPicpayController@search');
});

Auth::routes();




