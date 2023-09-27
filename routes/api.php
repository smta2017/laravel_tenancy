<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\ResetPasswordController;
use App\Http\Controllers\API\UserAPIController;
use App\Http\Controllers\VerificationController;
use App\Models\User;
use Doctrine\Inflector\Rules\Word;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Nnjeim\World\World;
use Nnjeim\World\WorldHelper;

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

Route::get('/csrf-token', function () {
    return response()->json(['csrf_token' => csrf_token()]);
});

Route::middleware('auth:sanctum')->get('/protected', [UserAPIController::class, 'index']);

Route::post('/send-opt', [RegisterController::class, 'sendotp']);
Route::post('/verify-otp', [RegisterController::class, 'verifyotp']);

Route::post('/create-tenant', [RegisterController::class, 'createTenant']);

Route::resource('users', App\Http\Controllers\API\UserAPIController::class)
    ->except(['create', 'edit']);

Route::get('email/verify/{id}',  [VerificationController::class, 'verify'])->name('verification.verify'); // Make sure to keep this as your route name
Route::post('email/resend', [VerificationController::class, 'resend'])->name('verification.resend');
//=======================================================================

Route::group(['prefix' => 'tenant'], function () {
    Route::post('login', [LoginController::class, "login"]);
    Route::post('register', [RegisterController::class, "createTenant"]);
    Route::post('register',function(){
        return "reg";
    });
    
    Route::group(['prefix' => 'password'], function () {
        Route::post('/email', [ResetPasswordController::class, 'sendResetLinkEmail']);
        Route::get('/reset', [ResetPasswordController::class, 'resetPassword']);

        // http://bassel.saas.test/api/password/reset?token=http%3A%2F%2Fsameh.test%2Fapi%2Fpassword%2Freset%3Ftoken%3D572ed3ffb35c100a002dfa737e3f004ffb8862b7577b358f51be1502a98cb014%26email%3Dbassel%2540email.com&email=bassel%40email.com

    });
});

// Password reset link request routes...
Route::post('password/reset', 'fack@fack')->name('password.reset');


//--------------------------------------------------------------------------------
Route::get('country', function () {
    $action =  World::countries();

    if ($action->success) {
        $countries = $action->data;
        //   return $countries;
    }
    //================
    $action =  World::countries([
        'fields' => 'states',
        'filters' => [
            'iso2' => 'DZ',
        ]
    ]);

    if ($action->success) {
        $countries = $action->data;
        // return $countries;
    }
    //==============
    $WorldHelper = new WorldHelper();

    $action = $WorldHelper->states([
        'filters' => [
            'country_id' => 66,
        ],
    ]);

    if ($action->success) {

        $states = $action->data;
        // return $states;
    }
    //================

    $WorldHelper = World::getCountryByCode("EGY");
    return $WorldHelper;
});

// Route::get('/generattoken/{tenant_id}/{user_id}', function (Request $request) {
//     $tenant = Tenant::find($request->tenant_id); // Replace this with your way of fetching the tenant.
//     $userToImpersonate = User::find($request->user_id); // Replace this with your way of fetching the user to impersonate.
//     $redirectUrl = '/api/users'; // The URL where the user should be redirected after impersonation.

//     $token = tenancy()->impersonate($tenant, $userToImpersonate->id, $redirectUrl);


//     $subdomain = $tenant->id; // Replace this with your way of fetching the tenant's primary domain.
//     return redirect("http://$subdomain.saas.test/impersonate/{$token->token}");
// });


