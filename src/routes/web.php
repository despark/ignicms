<?php

/*
|--------------------------------------------------------------------------
| Ignicms Web Routes
|--------------------------------------------------------------------------
*/
Route::get('/', ['as' => 'work', 'uses' => 'HomeController@index']);

if (config('ignicms.auth.default_routes', false)) {
    Auth::routes();
}

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
