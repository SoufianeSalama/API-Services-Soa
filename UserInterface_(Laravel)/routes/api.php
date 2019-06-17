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
/*
Route::middleware('auth:api')->get('/recordsjson', function (Request $request) {
    return "test";
});

*/
/*Route::post('/login', 'APIRecordsController@login')->name('login.api');

Route::middleware('auth:api')->group(function () {
    Route::get('/allrecords', 'APIRecordsController@index')->name('allrecords.api');
});

Route::get('recordsjson', 'APIRecordsController@index');*/

//Route::get('documentation', function(){
//    $sDocUrlPostman = "https://documenter.getpostman.com/view/7848926/S1Zw9BWW?version=latest";
//    header('Location: '.$sDocUrlPostman);
//});

Route::post('login', 'APIRecordsController@login');

Route::group(['middleware' => 'auth:api'], function() {
    Route::get('logout', 'APIRecordsController@logout');

    Route::get('allrecords', 'APIRecordsController@allRecords');
    Route::post('newrecord', 'APIRecordsController@newRecord');
    Route::put('updaterecord/{id}', 'APIRecordsController@updateRecord');

});
