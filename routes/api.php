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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['prefix' => 'auth'], function () {
    Route::post('signin', 'AuthController@signin');
    Route::post('signup', 'AuthController@signup');

    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
    });
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::group(['prefix' => 'books'], function () { 
        Route::get('/', 'BookController@index');
        Route::post('/', 'BookController@store');
        Route::get('/{book}', 'BookController@show');
        Route::put('/{book}', 'BookController@update');
        Route::delete('/{book}', 'BookController@destroy');
    });

    Route::group(['prefix' => 'authors'], function () { 
        Route::get('/', 'AuthorController@index');
        Route::post('/', 'AuthorController@store');
        Route::get('/{author}', 'AuthorController@show');
        Route::put('/{author}', 'AuthorController@update');
        Route::delete('/{author}', 'AuthorController@destroy');
    });
});
