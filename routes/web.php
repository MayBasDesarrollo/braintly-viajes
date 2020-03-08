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

Route::get('/', 'IndexController@index');

Route::get('/flights', 'FlightController@index')->name('flights');
Route::get('/searchFlight', 'FlightController@searchFlight')->name('searchFlight');

Route::get('reservation', 'ReservationController@index')->name('reservation.index');
Route::get('reservation/{flight}/new', 'ReservationController@create')->name('reservation.create');
Route::post('reservation', 'ReservationController@store');
Route::delete('reservation/{reservation}', 'ReservationController@destroy')->name('reservation.delete');
