<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->group(function(){
    Route::post('/zip', 'LocationController@zipInfo');
    Route::post('/location', 'LocationController@zipInfo');
    Route::post('/distance', 'LocationController@distance');

    Route::prefix('/appointments')->group(function(){
        Route::get('/', 'AppointmentController@index');
        Route::post('/', 'AppointmentController@store');
        Route::get('/{appointment}', 'AppointmentController@show');
        Route::put('/{appointment}', 'AppointmentController@update');
        Route::delete('/{appointment}', 'AppointmentController@destroy');
    });

    Route::prefix('/offices')->group(function(){
        Route::get('/', 'OfficeController@index');
        Route::get('/{office}', 'OfficeController@show');
    });

    Route::prefix('/properties')->group(function(){
        Route::get('/', 'PropertyController@index');
        Route::get('/{property}', 'PropertyController@show');
    });

    Route::prefix('/agents')->group(function(){
        Route::get('/', 'AgentController@index');
    });
});
