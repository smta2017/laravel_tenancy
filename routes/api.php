<?php

use App\Http\Controllers\Api\Auth\CentralLoginController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\ResetPasswordController;
use App\Http\Controllers\API\Central\CentralUserController;
use App\Http\Controllers\API\Central\PlanController;
use App\Http\Controllers\API\UserAPIController;
use App\Http\Controllers\VerificationController;
use App\Models\CentralUser;
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

// Route::middleware('auth:sanctum')->get('/protected', [UserAPIController::class, 'index']);

//login
Route::post('login', [CentralLoginController::class, "login"]);

use App\Http\Controllers\API\Central\SubscriptionController;
use App\Http\Controllers\API\Central\TenantController;
use App\Http\Controllers\API\NotificationController;

//users
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::resource('users', CentralUserController::class);
    Route::resource('tenants', TenantController::class);
    Route::resource('plans', PlanController::class);
    Route::resource('subscriptions', SubscriptionController::class);

    // Notifications
    Route::get('/notifications/unread-count', [NotificationController::class, 'unreadCount']);
    Route::put('/notifications/read-all', [NotificationController::class, 'markAllAsRead']);
    Route::put('/notifications/{id}/read', [NotificationController::class, 'markAsRead']);
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy']);
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::get('/translations', [\App\Http\Controllers\API\TranslationController::class, 'index']);
});

Route::post('/send-otp', [RegisterController::class, 'sendotp']);
Route::post('/verify-otp', [RegisterController::class, 'verifyotp']);

Route::post('/validate-register', [RegisterController::class, 'validateRegister']);
Route::post('/create-tenant', [RegisterController::class, 'createTenant']);


Route::get('email/verify/{id}',  [VerificationController::class, 'verify'])->name('verification.verify');
Route::post('email/resend', [VerificationController::class, 'resend'])->name('verification.resend');
//=======================================================================

Route::group(['prefix' => 'tenant'], function () {
    Route::post('login', [LoginController::class, "login"]);
    Route::post('register', [RegisterController::class, "createTenant"]);

    Route::group(['prefix' => 'password'], function () {
        Route::post('/forget-password', [ResetPasswordController::class, 'sendResetLinkEmail']);
        Route::post('/reset-password', [ResetPasswordController::class, 'resetPassword']);

        Route::post('/phone', [ResetPasswordController::class, 'sendResetPhoneOTP']);
        Route::get('/reset-phone', [ResetPasswordController::class, 'resetPassword']);
    });
});

// Password reset link request routes...
// Route::post('password/reset', 'fack@fack')->name('password.reset');


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

