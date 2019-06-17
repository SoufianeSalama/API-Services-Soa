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

//Route::get('/', function () {
//    return view('welcome');
//});

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('records', 'HomeController@index')->name('records');
Route::get('route', 'RouteController@index')->name('route');

//Forms
Route::post('newRecord', 'HomeController@newRecord')->name('newRecord');
Route::put('updateRecord/{id}', 'HomeController@updateRecord')->name('UpdateRecord');
Route::get('deviceParts/{id}', 'HomeController@deviceParts')->name('deviceParts');
Route::get('allRecords', 'HomeController@allRecords')->name('allRecords');