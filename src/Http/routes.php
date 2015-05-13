<?php

/*
|--------------------------------------------------------------------------
| Acl Routes
|--------------------------------------------------------------------------
*/

Route::resource('permission', 'Fos\Acl\Http\Controllers\PermissionController');
Route::resource('role', 'Fos\Acl\Http\Controllers\RoleController');