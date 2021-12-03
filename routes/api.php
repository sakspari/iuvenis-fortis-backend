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
Route::post('booking','Api\BookController@store'); //simpan data booking tertentu
Route::put('booking/{id}','Api\BookController@update'); //update data booking tertentu
Route::delete('booking/{id}','Api\BookController@destroy'); //update data booking tertentu

Route::get('user-room-reviews/{room_id}/{user_id}','Api\ReviewController@userRoomReview'); //ambill data review dari room tertentu
Route::get('room-reviews/{id}','Api\ReviewController@reviewWithUser'); //ambill data review dari room tertentu
Route::get('review/{id}','Api\ReviewController@show'); //ambil data review tertentu
Route::post('review','Api\ReviewController@store'); //simpan data review tertentu
Route::put('review/{id}','Api\ReviewController@update'); //update data booking tertentu
Route::delete('review/{id}','Api\ReviewController@destroy'); //update data booking tertentu

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
