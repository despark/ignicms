<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Ignicms Web Routes
|--------------------------------------------------------------------------
*/
Route::get('/', ['as' => 'work', 'uses' => 'HomeController@index']);
Auth::routes();
// Authentication routes...
//    Route::get('auth/login', 'Auth\AuthController@getLogin');
//    Route::post('auth/login', 'Auth\AuthController@postLogin');
//    Route::get('auth/logout', 'Auth\AuthController@getLogout');
//
//    // Registration routes...
//    // Route::get('auth/register', 'Auth\AuthController@getRegister');
//    // Route::post('auth/register', 'Auth\AuthController@postRegister');
//
//    // Password reset link request routes...
//    Route::get('password/email', 'Auth\PasswordController@getEmail');
//    Route::post('password/email', 'Auth\PasswordController@postEmail');
//
//    // Password reset routes...
//    Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
//    Route::post('password/reset', 'Auth\PasswordController@postReset');

// Admin
Route::group(['prefix' => 'admin'], function () {
    // Authentication Routes...
    Route::get('login', 'Admin\Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('login', 'Admin\Auth\AdminLoginController@login');

    Route::group(['middleware' => ['role:,access_admin']], function () {
        Route::get('/', ['as' => 'adminHome', 'uses' => 'Admin\AdminController@adminHome']);
        Route::get('/403', ['as' => 'adminForbidden', 'uses' => 'Admin\AdminController@forbidden']);

        Route::post('file/{file}', 'FileController@get')->name('file.get');
        Route::post('file/upload', 'File\UploadController@upload')->name('file.upload');
        Route::match(['get', 'post'], 'image/upload', 'Admin\ImageController@upload')->name('image.upload');
        Route::get('image/preview/{temp_image?}', 'Admin\ImageController@preview')->name('image.preview');
    });
});
