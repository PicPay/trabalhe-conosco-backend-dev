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

Route::resources([
    "/users" => "UserController"
]);
Route::get('/', function () {
    return response()->redirectTo("users");
});
//Route::get("/apidoc", function () {
//    response()->
//});

Route::get('/{home}', function () {
    return response()->redirectTo("users");
});
