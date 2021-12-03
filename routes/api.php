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

Route::get('user-bookings/{id}','Api\BookController@index'); //dipakai di review your room
Route::get('booking/{id}','Api\BookController@show'); //ambil data booking tertentu
Route::post('booking','Api\BookController@show'); //simpan data booking tertentu
Route::post('booking/{id}','Api\BookController@show'); //update data booking tertentu
