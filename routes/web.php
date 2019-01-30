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

Route::redirect('/', '/index', 301);

Route::group(['namespace' => 'Home', 'middleware'=>'web'],function ($router)
{
    $router->get('index', 'IndexController@index')->name('blog.index');
    $router->get('index/{slug}', 'IndexController@show')->name('blog.detail');
    $router->get('rss', 'IndexController@rss');
    $router->get('sitemap.xml', 'IndexController@siteMap');

    $router->get('contact', 'ContactController@showForm');
    $router->post('contact', 'ContactController@sendContactInfo');

    /*Route::post('pay', 'OrderController@pay');
    Route::get('payment/success', 'OrderController@paySuccess');
    Route::post('payment/notify', 'OrderController@notify');    // ping++后台设置的webhooks接收地址
    Route::get('buy/{id}', 'OrderController@buy');

    Route::get('goods', 'GoodsController@index');*/
});

Route::prefix('admin')->group(function ($router) {
    $router->resource('categories', 'CategoriesController', ['except' => 'show']);
    $router->resource('tags', 'TagsController', ['except' => 'show']);
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

    $router->redirect('/', '/admin/article', 301);
    $router->resource('article', 'ArticleController');
    $router->resource('config', 'ConfigController', ['except' => 'show']);
    $router->post('config/setOrder', 'ConfigController@setOrder');
    $router->post('config/setConf', 'ConfigController@setConf');

    $router->get('upload', 'UploadController@index');
    $router->post('upload/file', 'UploadController@uploadFile');
    $router->delete('upload/file', 'UploadController@deleteFile');
    $router->post('upload/folder', 'UploadController@createFolder');
    $router->delete('upload/folder', 'UploadController@deleteFolder');

    $router->get('task/{project}', 'TaskController@index');
});
