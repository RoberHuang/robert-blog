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

Route::prefix('admin')->namespace('Admin')->group(function ($router) {
    $router->get('login', 'LoginController@showLoginForm')->name('admin.login');
    $router->post('login', 'LoginController@login');
    /*$router->get('register', 'LoginController@showRegister')->name('admin.register');
    $router->post('register', 'LoginController@register');*/
    $router->post('logout', 'LoginController@logout')->name('admin.logout');
    $router->post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');       //发送重置密码的邮件
    $router->get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');     //发送重置密码邮件的表单页面
    $router->post('password/reset', 'ResetPasswordController@reset');                                                   //重置密码
    $router->get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('admin.password.reset');      //重置密码表单
});

Route::get('/admin', function () {
    return redirect('/admin/article');
});

Route::group(['prefix' => 'admin','namespace' => 'Admin', 'middleware'=>'web'],function ($router)
{
    Route::resource('article', 'ArticleController');
    Route::resource('tag', 'TagController', ['except' => 'show']);

    Route::get('upload', 'UploadController@index');
    Route::post('upload/file', 'UploadController@uploadFile');
    Route::delete('upload/file', 'UploadController@deleteFile');
    Route::post('upload/folder', 'UploadController@createFolder');
    Route::delete('upload/folder', 'UploadController@deleteFolder');
});