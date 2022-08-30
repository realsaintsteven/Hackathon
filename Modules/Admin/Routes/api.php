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
    Route::namespace('Admin')->prefix('admin')->group(function() {
        Route::prefix('auth')->group(function() {
            Route::post('login', 'Auth\LoginController@login');
            // Route::post('forgot-password', 'Auth\ForgotPasswordController@sendResetLinkEmail');
            // Route::post('reset-password', 'Auth\ResetPasswordController@reset');

            Route::middleware('auth:admin')->group(function() {
                Route::post('logout', 'Auth\LoginController@logout');
                Route::post('refresh', 'Auth\LoginController@refresh');
            });
        });

        Route::middleware('auth:admin')->group(function() {
            Route::get('report', 'DashboardController@report');
            Route::resource('admins', 'AdminController');
            Route::resource('roles', 'RoleController');
            Route::get('permissions', 'RoleController@permissions');
            Route::patch('account/profile', 'AccountController@updateProfile');
			Route::patch('account/password', 'AccountController@updatePassword');
        });
	});
});