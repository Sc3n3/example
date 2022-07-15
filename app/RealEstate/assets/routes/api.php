<?php

use Illuminate\Support\Facades\Route;

Route::prefix('/appointments')->group(function(){
    Route::get('/distance', 'AppointmentController@distance');

    Route::get('/', 'AppointmentController@index');
    Route::post('/', 'AppointmentController@store');
    Route::get('/{appointment}', 'AppointmentController@show');
    Route::patch('/{appointment}', 'AppointmentController@update');
    Route::delete('/{appointment}', 'AppointmentController@destroy');
});

Route::prefix('/offices')->group(function(){
    Route::get('/', 'AppointmentController@index');
    Route::post('/', 'AppointmentController@store');
    Route::get('/{office}', 'AppointmentController@show');
    Route::patch('/{office}', 'AppointmentController@update');
    Route::delete('/{office}', 'AppointmentController@destroy');
});