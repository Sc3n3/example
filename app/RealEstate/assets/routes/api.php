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
    Route::get('/', 'OfficeController@index');
    Route::post('/', 'OfficeController@store');
    Route::get('/{office}', 'OfficeController@show');
    Route::patch('/{office}', 'OfficeController@update');
    Route::delete('/{office}', 'OfficeController@destroy');
});

Route::prefix('/properties')->group(function(){
    Route::get('/', 'OfficeController@index');
    Route::post('/', 'OfficeController@store');
    Route::get('/{property}', 'OfficeController@show');
    Route::patch('/{property}', 'OfficeController@update');
    Route::delete('/{property}', 'OfficeController@destroy');
});