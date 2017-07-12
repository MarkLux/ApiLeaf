<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/logout','Auth\LoginController@logout');

Route::get('/home', 'HomeController@index');

Route::post('/api/test','RequestTestController@sendTestRequest');
Route::get('/api/test','RequestTestController@getIndex');

Route::get('/api/edit','ApiDocController@editApiDoc');
Route::post('/api/edit','ApiDocController@editApiDoc');

Route::post('/api/generate','ApiDocController@generate');


Route::get('/test','ApiDocController@generate');
Route::get('/api/doc/{id}','ApiDocController@renderDoc');

Route::get('/collection/create','ApiCollectionController@getCreate');
Route::post('/collection/create','ApiCollectionController@postCreate');
Route::get('/collection/update/{id}','ApiCollectionController@getUpdate');
Route::post('/collection/update/{id}','ApiCollectionController@postUpdate');
Route::get('/collection/delete/{id}','ApiCollectionController@delete');