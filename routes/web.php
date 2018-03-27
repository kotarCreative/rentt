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

Route::get('/', 'HomeController@index');
Route::get('/feedback', 'HomeController@feedback');

Route::post('/users', 'UsersController@store');
Route::get('/profile/edit', 'UsersController@edit');

Route::get('subdivisions/{subdivision}/cities', 'CitiesController@subdivisionCities');
Route::get('countries/{country}/subdivisions', 'CitiesController@countrySubdivisions');

Route::group([ 'prefix' => 'properties' ], function() {
    Route::get('/', 'PropertiesController@index');
    Route::get('/search', 'PropertiesController@search');
    Route::get('/details', 'PropertiesController@details');
    Route::group([ 'middleware' => 'auth' ], function() {
        Route::get('/create', 'PropertiesController@create');
        Route::post('/', 'PropertiesController@store');
        Route::get('/{property}', 'PropertiesController@edit');
        Route::patch('/{property}', 'PropertiesController@update');
        Route::post('/{property}/contact', 'PropertiesController@contactOwner');
        Route::post('/{property}/reviews', 'PropertiesController@storeReview');
    });
    Route::get('/{property}', 'PropertiesController@show');
});
