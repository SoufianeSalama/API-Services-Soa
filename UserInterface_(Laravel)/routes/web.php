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


Route::get('/', function () {
    return view('welcome');
});*/

//Route::get('/recordsapi', 'RecordController@recordslist'); //De ajax request worden gestuurd naar de API controller



Route::group(['middleware' => 'auth:api'], function(){
    Route::get('/route', 'RouteController@index')->name('route');

});

Route::get('/','RecordController@index')->name('records');
Route::get('/records','RecordController@index')->name('records');

Auth::routes();