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


Route::group(['middleware' =>['jwt.verify']], function () {
    Route::get('logout', 'ApiController@logout');
    Route::get('user', 'ApiController@getAuthUser');
    Route::put('user', 'ApiController@updateAuthUser');
    // Route::resource('categorie','CategorieController');

    Route::resource('location','LocationController');
    Route::resource('Penalite','PenaliteController');
    
});

