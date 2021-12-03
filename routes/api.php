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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('user','Api\UserController@index');
Route::get('user/{id}','Api\UserController@show');
Route::post('user','Api\UserController@store');
Route::put('user/{id}','Api\UserController@update');
Route::delete('user/{id}','Api\UserController@destroy');

Route::get('room','Api\RoomController@index');
Route::get('room/{id}','Api\RoomController@show');
Route::post('room','Api\RoomController@store');
Route::put('room/{id}','Api\RoomController@update');
Route::delete('room/{id}','Api\RoomController@destroy');
