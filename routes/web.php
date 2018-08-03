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
Route::get('/register/verify/{token}', 'Auth\RegisterController@verify');

Route::get('/', 'HomeController@index')->name('home');
Route::get('/about', 'HomeController@about')->name('about');
Route::get('/feedback', 'HomeController@feedback');
Route::post('/feedback', 'HomeController@sendFeedback');
Route::get('/privacy', 'HomeController@privacy');

Route::get('subdivisions/{subdivision}/cities', 'CitiesController@subdivisionCities');
Route::get('countries/{country}/subdivisions', 'CitiesController@countrySubdivisions');
Route::get('languages', 'UsersController@languages');

Route::group([ 'prefix' => 'properties' ], function() {
    $p = 'PropertiesController@';

    Route::group([ 'middleware' => 'auth' ], function() use ($p) {
        Route::post('/{property}/contact', $p.'contactOwner');
        Route::post('/{property}/reviews', $p.'storeReview');

        Route::group([ 'middleware' => 'role:landlord' ], function() use($p) {
            Route::get('/create', $p.'create');
            Route::post('/', $p.'store');
            Route::get('/{property}/edit', $p.'edit');
            Route::patch('/{property}', $p.'update');
            Route::delete('/{property}', $p.'destroy');
        });
    });

    Route::get('/', $p.'index');
    Route::get('/search', $p.'search');
    Route::get('/details', $p.'details');
    Route::get('/{property}', $p.'show');
});

Route::get('profile/edit', 'UsersController@edit');
Route::patch('profile', 'UsersController@update');
Route::resource('profile', 'UsersController', [ 'except' => [ 'create', 'edit', 'update' ] ]);
Route::get('profile/references/verify/{token}', 'UsersController@approveReference');
Route::get('profile/rental-history/verify/{token}', 'UsersController@approveRentalHistory');

Route::post('users/{profile}/reviews', 'UsersController@storeReview');
Route::post('users/contact', 'UsersController@contact');
