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

Route::get('vehicleroute/{key}/{objectId}/{startdate}/{enddate}', "MapController@getVehicleRoute");
Route::get('vehicles/{key}', "MapController@getVehicles");
Route::get('/', "MapController@home");