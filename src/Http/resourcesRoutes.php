<?php

Route::resource('users', 'Admin\UsersController');
Route::resource('seo_pages', 'Admin\SeoPagesController');
Route::resource('roles', 'Admin\RolesController');
Route::resource('permissions', 'Admin\PermissionsController');

Route::controller('profile', 'Admin\ProfileController', [
    'getEdit' => 'admin.profile.edit',
    'postUpdate' => 'admin.profile.update',
]);
