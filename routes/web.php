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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'MainController@index');

Route::get('/getSearchFields', 'MainController@getSearchFieldIDs');

Route::post('/updateSearchField', 'MainController@updateSearchField');

Route::post('/updateDayTime', 'MainController@updateDayTime');

Route::post('/updateTravelMode', 'MainController@updateTravelMode');
