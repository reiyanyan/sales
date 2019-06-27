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

Route::post('/login', 'UserController@login')->name('apiLogin');
Route::get('/profile/{id}', 'UserController@profile')->name('apiProfile');
Route::get('/job/active/all/{id}', 'UserController@job_active_all')->name('apiJob_active_all');
Route::get('/job/active/{id}', 'UserController@job_active')->name('apiJob_active');
//send report
Route::post('/report/send', 'UserController@report_send')->name('apiReport_send');
//getAllJobReport
Route::get('/report/all/{id}', 'UserController@report_all')->name('apiReport_all');
Route::get('/report/{report_id}', 'UserController@report_id')->name('apiReport_id');
//pictures

//unused
Route::get('simple', 'UserController@simpleApi');
