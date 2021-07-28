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



Route::group(['as' => 'api.', 'namespace' => 'App\Http\Controllers'], function () {

    Route::group(['prefix' => 'auth', 'as' => 'auth.', 'namespace' => 'Auth'], function () {
        Route::post('/register', 'RegisterController@register')->name('register');
        Route::post('/login', 'LoginController@login')->name('login');
        Route::middleware('auth:sanctum')->get('/me', function (Request $request) {
            return $request->user();
        })->name('user');
    });

    // Protected routes
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::resource('users', 'UsersController')->except(['edit', 'create']);
    });
});
