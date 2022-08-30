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
    Route::resource('all_competitions', 'CompetitionController');
    Route::namespace('User')->group(function() {
       // Route::prefix('auth')->group(function() {
            Route::resource('teams', 'TeamController');
             Route::resource('competitions', 'CompetitionController');
             Route::resource('submissions', 'SubmissionController');
            //  Route::post('register', 'Auth\RegisterController@register');


     //   });
           
           
        
    });

    Route::namespace('Admin')->prefix('admin')->group(function() {
        Route::middleware('auth:admin')->group(function() {
            Route::resource('competitions', 'CompetitionController');
            
            // Route::resource('users', 'UserController');
            // Route::get('mentors', 'UserController@mentors');
        });
    });
});