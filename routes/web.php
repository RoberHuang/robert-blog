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
    return redirect('/index'); //view('welcome');
});

Route::group(['namespace' => 'Home', 'middleware'=>'web'],function ($router)
{
    Route::get('/index', 'IndexController@index')->name('blog.index');
    Route::get('/index/{slug}', 'IndexController@show')->name('blog.detail');
});

