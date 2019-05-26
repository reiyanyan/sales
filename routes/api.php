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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/signin', 'UserController@signin')->name('apiSignin');


// Route::group(['middleware' => ['cors']], function () {
    //
    // });
Route::post('/user/update', 'UserController@update')->name('update_sales');
Route::post('/user/store', 'UserController@store')->name('update_sales');
Route::post('/user/delete', 'UserController@delete')->name('delete_sales');
//sales
Route::get('/user/list_sales', 'UserController@list_sales')->name('list_sales');

//unused
Route::get('simple', 'UserController@simpleApi');
