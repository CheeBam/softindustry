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


Route::group(['prefix' => 'v1'], function () {
    Route::get('project', 'Api\V1\ProjectController@index');

    Route::group(['prefix' => 'employee'], function () {
        Route::apiResource('/', 'Api\V1\EmployeeController');
        Route::post('image', 'Api\V1\EmployeeController@uploadImage');
        Route::post('average', 'Api\V1\EmployeeController@getAverages');
    });
});


