<?php

/*
|--------------------------------------------------------------------------
| Acl Routes
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => config('acl.routes_prefix')], function () {
    Route::resource('permission', 'Fos\Acl\Http\Controllers\PermissionController');
    Route::resource('role', 'Fos\Acl\Http\Controllers\RoleController');
});
