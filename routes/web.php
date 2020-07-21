<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'tasksController@index')->middleware('auth');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/* task */
Route::get('/task', 'tasksController@index')->middleware('auth');
Route::get('/addtask', 'tasksController@addtaskShow')->middleware('auth');
Route::post('/addtask', 'tasksController@addtaskSubmit')->middleware('auth');
Route::get('/viewtask/{id}', 'tasksController@viewtaskShow')->middleware('auth');
Route::get('/updatetask/{id}', 'tasksController@updatetaskShow')->middleware('auth');
Route::put('/updatetask/{id}', 'tasksController@updatetaskSubmit')->middleware('auth');
Route::get('/approvetask/{id}', 'tasksController@approvetaskShow')->middleware('auth');
Route::put('/approvetask/{id}', 'tasksController@approvetaskSubmit')->middleware('auth');
Route::delete('/deletetask/{id}', 'tasksController@deletetaskSubmit')->middleware('auth');
Route::get('/canceltask/{id}', 'tasksController@canceltaskSubmit')->middleware('auth');
Route::put('/uncanceltask/{id}', 'tasksController@uncanceltaskSubmit')->middleware('auth');
Route::get('/gettaskDataTable', 'tasksController@gettaskDataTableSubmit')->middleware('auth');
Route::get('/storage/files/{filename}', 'tasksController@gettaskFileSubmit')->middleware('auth');

/* fbsg-signature-addLocaleENTH:<begin> */
Route::get('lang/{lang}', ['as'=>'lang.switch', 'uses'=>'LangSwitcherController@switchLang']);
/* fbsg-signature-addLocaleENTH:<end> */

Route::get('login/{provider}',          'Auth\SocialAccountController@redirectToProvider');
Route::get('login/{provider}/callback', 'Auth\SocialAccountController@handleProviderCallback');
Route::get('sendEmail', 'SendMailController@sendEmail');
