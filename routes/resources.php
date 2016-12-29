<?php

Route::resource('user', 'Admin\UsersController');
Route::resource('seo_page', 'Admin\SeoPagesController');
Route::resource('role', 'Admin\RolesController');
Route::resource('permission', 'Admin\PermissionsController');

Route::get('profile/edit', ['uses' => 'Admin\ProfileController@edit', 'as' => 'admin.profile.edit']);
Route::get('profile/update', ['uses' => 'Admin\ProfileController@update', 'as' => 'admin.profile.update']);
