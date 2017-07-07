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

Route::get('/home', 'HomeController@index');

Route::post('/test-api','RequestTestController@sendTestRequest');
Route::get('/test-api','RequestTestController@getIndex');

Route::get('/edit-api','ApiDocController@editApiDoc');
Route::post('/edit-api','ApiDocController@editApiDoc');

Route::get('/api-doc',function (){
    return view('apidoc');
});