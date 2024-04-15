<?php


use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [LoginController::class,'index']);
Route::post('/login', [LoginController::class,'login']);


Route::get('/home', [HomeController::class,'index']);

Route::get('/test', function (Request $request) {

    $data = [
        // "img_url" => "https://qwzayb.stripocdn.email/content/guids/CABINET_75694a6fc3c4633b3ee8e3c750851c02/images/26081522074491960.png",
        "head_line" => "Forget password email confirmation.",
        "paragraph" => "You are receiving this email because we received a password reset request for your account.",
        "callback" => "fghjkl",
        "footer" => "footer",
        "user" => "user",
        "enable_subscribe" => false,
        "footer_address_line1" => "675 Massachusetts Avenue",
        "footer_address_line2" => "Cambridge, MA 02130",

    ];
   return view('emails.reset-password', ['data' => $data]);
    return ;
});