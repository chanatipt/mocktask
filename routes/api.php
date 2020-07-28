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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/* task */
Route::get('/task', 'tasksController@index')->middleware('auth:api');
Route::post('/addtask', 'tasksController@addtaskSubmit')->middleware('auth:api');
Route::get('/viewtask/{id}', 'tasksController@viewtaskShow')->middleware('auth:api');
Route::put('/updatetask/{id}', 'tasksController@updatetaskSubmit')->middleware('auth:api');
Route::put('/approvetask/{id}', 'tasksController@approvetaskSubmit')->middleware('auth:api');
Route::delete('/deletetask/{id}', 'tasksController@deletetaskSubmit')->middleware('auth:api');
Route::get('/canceltask/{id}', 'tasksController@canceltaskSubmit')->middleware('auth:api');
Route::put('/uncanceltask/{id}', 'tasksController@uncanceltaskSubmit')->middleware('auth:api');
Route::get('/gettaskDataTable', 'tasksController@gettaskDataTableSubmit')->middleware('auth:api');

Route::post('/viewtaskByCode/{code}', 'tasksController@viewtaskByCodeSubmit')->middleware('auth:api');
Route::post('/sendtaskFileMail/{code}/{email}', 'tasksController@sendtaskFileMailSubmit')->middleware('auth:api');
