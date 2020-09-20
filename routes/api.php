<?php

use Illuminate\Http\Request;

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


Route::post('login', 'ApiController@login');
Route::post('register', 'ApiController@register');
Route::resource('vehicule','VehiculeController');

Route::get('categorie','CategorieController@index');
Route::get('test', 'ApiController@test');

Route::get('reservations','LocationController@reservations');
Route::get('vehicules','VehiculeController@vehicules');

Route::group(['middleware' =>['jwt.verify']], function () {
    Route::get('logout', 'ApiController@logout');
    Route::get('user', 'ApiController@getAuthUser');
    Route::put('user', 'ApiController@updateAuthUser');

    Route::get('users', 'ApiController@getUsers');
    Route::post('users', 'ApiController@addUsers');
    Route::put('users/{id}', 'ApiController@updateUsers');

    Route::post('categorie','CategorieController@store');
    Route::put('categorie/{id}','CategorieController@update');
    // Route::resource('categorie','CategorieController');

    Route::post('vehicule/{id}','VehiculeController@updateVehicule');

    
    Route::resource('location','LocationController');
    Route::resource('Penalite','PenaliteController');


    Route::delete('users', 'ApiController@deleteUsers');
    Route::delete('categories', 'CategorieController@deleteCategories');
    Route::delete('reservations', 'LocationController@deleteLocations');
    Route::delete('vehicules', 'VehiculeController@deleteVehicules');

    Route::get('home', 'DashboardController@home');
    
});

