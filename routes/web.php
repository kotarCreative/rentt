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

Route::get('/', 'HomeController@index');
Route::get('/feedback', 'HomeController@feedback');

Auth::routes();

Route::group([ 'middleware' => 'auth' ], function() {
    Route::group([ 'prefix' => 'properties' ], function() {
        Route::get('/create', 'PropertiesController@create');
    });
});
