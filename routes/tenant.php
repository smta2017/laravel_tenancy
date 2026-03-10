<?php

declare(strict_types=1);

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\ResetPasswordController;
use App\Http\Controllers\Api\RolePermissionController;
use App\Http\Controllers\API\UserAPIController;
use App\Http\Controllers\API\NotificationController;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use Nnjeim\World\World;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'api',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {

    Route::get('/', function () {
        return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
    });


    //====================================[  A P I  ]==============================================
    Route::group(['prefix' => 'api'], function () {
        Route::get('country', function () {
            $countries = World::Countries();
        });

        Route::get('/tenant/password/reset', [ResetPasswordController::class, 'resetPassword']);

        Route::group(['middleware' => 'auth:sanctum'], function () {

            // Notifications
            Route::get('/notifications/unread-count', [NotificationController::class, 'unreadCount']);
            Route::put('/notifications/read-all', [NotificationController::class, 'markAllAsRead']);
            Route::put('/notifications/{id}/read', [NotificationController::class, 'markAsRead']);
            Route::delete('/notifications/{id}', [NotificationController::class, 'destroy']);
            Route::get('/notifications', [NotificationController::class, 'index']);

            Route::resource('/users', UserAPIController::class);
            // Route::post('/users', [UserAPIController::class, 'store']);
            Route::put('/users/verify-accout', [UserAPIController::class, 'verifyAccout']);
            Route::put('/users/{id}', [UserAPIController::class, 'update']);

            // assign-role   
            Route::post('/users/{id}/assign-roles', [UserAPIController::class, 'assignRoles']);
            // assign-permission
            Route::post('/users/{id}/assign-permissions', [UserAPIController::class, 'assignPermissions']);


            Route::group(['prefix' => 'auth'], function () {
                Route::get('/me', [LoginController::class, 'me']);
                Route::post('/me/image', [LoginController::class, 'updateProfileImage']);
            });

            // Permissions
            Route::get('/roles-permissions', [RolePermissionController::class, 'index']);
            Route::post('/roles', [RolePermissionController::class, 'createRole']);
            Route::post('/permissions', [RolePermissionController::class, 'createPermission']);
            Route::post('/roles/{role}/assign-permissions', [RolePermissionController::class, 'assignPermissionToRole']);
            Route::post('/roles/{role}/remove-permissions', [RolePermissionController::class, 'removePermissionFromRole']);
            Route::delete('/roles/{role}', [RolePermissionController::class, 'deleteRole']);
            Route::delete('/permissions/{permission}', [RolePermissionController::class, 'deletePermission']);
            Route::get('/roles/{role}', [RolePermissionController::class, 'showRole']);
            Route::get('/roles/{role}/permissions', [RolePermissionController::class, 'getRolePermissions']);
            Route::get('/permissions/{permission}/roles', [RolePermissionController::class, 'getPermissionRoles']);
            // End-Permissions

            Route::resource('cases', App\Http\Controllers\API\TheCaseAPIController::class)->except(['create', 'edit']);
        });
    });
    //====================================[ END - A P I  ]==============================================

});
