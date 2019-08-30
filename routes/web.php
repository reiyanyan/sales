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

// autenikasi jika user belum login
//Route::group(["middleware" => 'authlogin'], function(){

  Route::get('/home', 'UserController@index')->name('user_management');
  Route::get('/laporan', 'UserController@laporan')->name('laporan');
  Route::get('/job_management', 'UserController@job_management')->name('job_management');

  Route::post('/user/update', 'UserController@update')->name('update_sales');
  Route::post('/user/store', 'UserController@store')->name('store_sales');
  Route::post('/user/delete', 'UserController@delete')->name('delete_sales');
  Route::post('/user/search', 'UserController@search')->name('search_sales');
  //sales
  Route::get('/user/list_sales', 'UserController@list_sales')->name('list_sales');
  Route::get('/user/list_sales/outpage', 'UserController@list_sales_outpage')->name('list_sales_outpage');
  Route::get('/user/get_job/{id}', 'UserController@getJob')->name('get_job');
  Route::post('/user/store_job', 'UserController@store_Job')->name('store_job');
  Route::post('/user/delete_job', 'UserController@delete_job')->name('delete_job');
  //list_report
  Route::get('/list_report/recent', 'UserController@list_report_recent')->name('list_report_recent');
  Route::get('/list_report/previous', 'UserController@list_report_previous')->name('list_report_previous');
  Route::post('/list_report/search/', 'UserController@list_report_search')->name('list_report_search');

  Route::get('/report/foto/{laporan_id}', 'UserController@get_foto')->name('get_foto');

//});
