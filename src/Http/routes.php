<?php

/*
|--------------------------------------------------------------------------
| Acl Routes
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => config('acl.routes_prefix')], function () {
    Route::resource('permission', 'Aginev\Acl\Http\Controllers\PermissionController');
    Route::resource('role', 'Aginev\Acl\Http\Controllers\RoleController');
});
