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


Auth::routes();
Route::get('/', 'HomeController@index')->middleware('guest');



Route::group([
    'middleware' => ['auth']
], function(){
    Route::get('/home', 'HomeController@home');
    Route::get('/soon-application/{term}/create', 'SoonApplicationController@create');
    Route::post('/soon-application/{term}', 'SoonApplicationController@store');
});


Route::get('birthday', 'HomeController@birthday');


