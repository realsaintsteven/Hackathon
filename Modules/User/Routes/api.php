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

Route::namespace('Api')->prefix('v1')->group(function() {
    Route::namespace('User')->group(function() {
        Route::prefix('auth')->group(function() {
            Route::post('login', 'Auth\LoginController@login');
            Route::post('register', 'Auth\RegisterController@register');
            Route::post('forgot-password', 'AccountController@forgotPassword');
            Route::post('reset-password', 'AccountController@resetPassword');
           
            Route::middleware('auth')->group(function() {            
                Route::post('refresh', 'Auth\LoginController@refresh');
                Route::post('logout', 'Auth\LoginController@logout');
            });
        });

        // Route::middleware('auth')->group(function() {
        //     Route::get('report', 'DashboardController@report');
           
        //     Route::post('account/profile', 'AccountController@updateProfile');
        //     Route::post('account/password', 'AccountController@updatePassword');
        //     Route::post('account/image', 'AccountController@uploadImage');
        //     Route::post('account/kyc', 'AccountController@updateKyc');
        // });
    });

    Route::namespace('Admin')->prefix('admin')->group(function() {
        Route::middleware('auth:admin')->group(function() {
           
            Route::resource('users', 'UserController');
            Route::get('mentors', 'UserController@mentors');
        });
    });
});