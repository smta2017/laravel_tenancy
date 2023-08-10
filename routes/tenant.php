<?php

declare(strict_types=1);

use App\Http\Controllers\API\UserAPIController;
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

        Route::post('/impersonate', [UserAPIController::class, "impersonate"]);

        Route::middleware('impersonate')->group(function () {
            Route::group(['middleware' => 'auth:sanctum'], function () {
                Route::apiResource('/users', UserAPIController::class);
            });
        });
    });
    //====================================[ END - A P I  ]==============================================

});
