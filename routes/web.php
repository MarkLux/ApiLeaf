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

Route::get('/api/update/{id}','ApiDocController@getUpdate');
Route::post('/api/update/{id}','ApiDocController@postUpdate');

Route::get('/api/delete/{id}','ApiDocController@delete');

Route::post('/api/generate','ApiDocController@generate');


Route::get('/test','ApiDocController@generate');
Route::get('/api/doc/{id}','ApiDocController@renderDoc');

Route::get('/collection/create','ApiCollectionController@getCreate');
Route::post('/collection/create','ApiCollectionController@postCreate');
Route::get('/collection/update/{id}','ApiCollectionController@getUpdate');
Route::post('/collection/update/{id}','ApiCollectionController@postUpdate');
Route::get('/collection/delete/{id}','ApiCollectionController@delete');

Route::get('/share/{id}','ApiShareController@getManageView');
Route::post('/share/{id}/member/add','ApiShareController@addMember');
Route::get('/share/{id}/member/delete','ApiShareController@deleteMember');

Route::get('/api/doc/{id}/favor','ApiFavorController@favor');
Route::get('/api/doc/{id}/unfavor','ApiFavorController@unfavor');

Route::get('/api/codes/{id}','ApiCodesController@getView');
Route::get('/api/codes/{id}/edit','ApiCodesController@getEditView');
Route::post('/api/codes/{id}/update','ApiCodesController@updateCodes');

Route::get('/api/{id}/data-dict', 'DataDictController@getListView');
Route::get('/api/data-dict/{id}/edit','DataDictController@getEditView');
Route::post('/api/data-dict/{dictId}/update','DataDictController@postUpdate');
Route::get('/api/data-dict/{collectionId}/create','DataDictController@getCreateView');
Route::post('/api/data-dict/{collectionId}/create','DataDictController@postCreate');
Route::get('/api/data-dict/{dictId}/delete','DataDictController@deleteDict');

Route::post('/api/{collectionId}/data-dict/match','DataDictController@matchDict');

Route::get('/about',function () {
    return view('about');
});