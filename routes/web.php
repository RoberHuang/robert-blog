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

Route::redirect('/', '/posts', 301);

Route::get('/posts', 'PostsController@index')->name('posts.index');
Route::get('/posts/{slug}', 'PostsController@show')->name('posts.show');
Route::get('/contacts', 'ContactsController@index')->name('contacts.index');
Route::post('/contacts', 'ContactsController@store')->name('contacts.store');
Route::get('/rss', 'PublicController@rss');
Route::get('/site-map.xml', 'PublicController@siteMap');

/*Route::get('/goods', 'GoodsController@index');
Route::get('/payments/{id}', 'PaymentsController@show');
Route::post('/payments', 'PaymentsController@pay');
Route::get('/payments/success', 'PaymentsController@paySuccess');
Route::post('/payments/notify', 'PaymentsController@notify');    // ping++后台设置的webhooks接收地址*/


Route::prefix('admin')->group(function ($router) {
    $router->redirect('/', '/admin/posts', 301);
    $router->resource('/posts', 'PostsController');
    $router->resource('/categories', 'CategoriesController', ['except' => 'show']);
    $router->resource('/tags', 'TagsController', ['except' => 'show']);

    $router->post('/configs/setOrder', 'ConfigController@setOrder');
    $router->post('/configs/setConf', 'ConfigsController@setConf');
    $router->resource('/configs', 'ConfigsController', ['except' => 'show']);
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

    $router->get('upload', 'UploadController@index');
    $router->post('upload/file', 'UploadController@uploadFile');
    $router->delete('upload/file', 'UploadController@deleteFile');
    $router->post('upload/folder', 'UploadController@createFolder');
    $router->delete('upload/folder', 'UploadController@deleteFolder');

    $router->get('task/{project}', 'TaskController@index');
});
