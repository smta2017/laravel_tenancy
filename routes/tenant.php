<?php

declare(strict_types=1);

use App\Http\Controllers\Api\Auth\ResetPasswordController;
use App\Http\Controllers\Api\ProductAPIController;
use App\Http\Controllers\Api\RolePermissionController;
use App\Http\Controllers\Api\UserAPIController;
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


        Route::group(['middleware' => 'auth:sanctum'], function () {

            Route::get('/users', [UserAPIController::class, 'index']);



            Route::resource('suppliers', App\Http\Controllers\Api\SupplierAPIController::class)
                ->except(['create', 'edit']);

            Route::resource('customers', App\Http\Controllers\Api\CustomerAPIController::class)
                ->except(['create', 'edit']);

            Route::resource('brands', App\Http\Controllers\Api\BrandAPIController::class)
                ->except(['create', 'edit']);

            Route::resource('categories', App\Http\Controllers\Api\CategoryAPIController::class)
                ->except(['create', 'edit']);

            Route::resource('statuses', App\Http\Controllers\Api\StatusAPIController::class)
                ->except(['create', 'edit']);

            Route::resource('units', App\Http\Controllers\Api\UnitAPIController::class)
                ->except(['create', 'edit']);

            Route::resource('warehouses', App\Http\Controllers\Api\WarehouseAPIController::class)
                ->except(['create', 'edit']);

            Route::get('/products/list-sale', [ProductAPIController::class, 'productListForSale']);
            Route::resource('products', ProductAPIController::class)
                ->except(['create', 'edit']);

            Route::resource('purchase-statues', App\Http\Controllers\Api\PurchaseStatuesAPIController::class)
                ->except(['create', 'edit']);

            Route::resource('purchases', App\Http\Controllers\Api\PurchaseAPIController::class)
                ->except(['create', 'edit']);

            Route::resource('purchase-details', App\Http\Controllers\Api\PurchaseDetailsAPIController::class)
                ->except(['create', 'edit']);

            Route::resource('sale-statues', App\Http\Controllers\Api\SaleStatuesAPIController::class)
                ->except(['create', 'edit']);

            Route::resource('sales', App\Http\Controllers\Api\SaleAPIController::class)
                ->except(['create', 'edit']);

            Route::resource('sale-details', App\Http\Controllers\Api\SaleDetailAPIController::class)
                ->except(['create', 'edit']);

            Route::resource('inventories', App\Http\Controllers\Api\InventoryAPIController::class)
                ->except(['create', 'edit']);



            Route::group(['prefix' => 'auth'], function () {
                Route::get('/me', [UserAPIController::class, 'me']);
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

        });
    });
    //====================================[ END - A P I  ]==============================================

});
