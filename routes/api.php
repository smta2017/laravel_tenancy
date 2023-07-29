<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\API\UserAPIController;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->post('/user', function (Request $request) {
    return User::all();
});

Route::middleware('auth:sanctum')->get('/protected', [UserAPIController::class, 'index']);

Route::post('/send-opt', [RegisterController::class, 'sendotp']);
Route::post('/verify-otp', [RegisterController::class, 'verifyotp']);

Route::post('/create-tenant', [RegisterController::class, 'createTenant']);

Route::resource('users', App\Http\Controllers\API\UserAPIController::class)
    ->except(['create', 'edit']);
//=======================================================================

Route::group(['prefix' => 'tenant'], function () {
    Route::post('login', [LoginController::class, "login"]);
    Route::get('register', [RegisterController::class, "createTenant"]);
});


// Route::get('/generattoken/{tenant_id}/{user_id}', function (Request $request) {
//     $tenant = Tenant::find($request->tenant_id); // Replace this with your way of fetching the tenant.
//     $userToImpersonate = User::find($request->user_id); // Replace this with your way of fetching the user to impersonate.
//     $redirectUrl = '/api/users'; // The URL where the user should be redirected after impersonation.

//     $token = tenancy()->impersonate($tenant, $userToImpersonate->id, $redirectUrl);


//     $subdomain = $tenant->id; // Replace this with your way of fetching the tenant's primary domain.
//     return redirect("http://$subdomain.saas.test/impersonate/{$token->token}");
// });
