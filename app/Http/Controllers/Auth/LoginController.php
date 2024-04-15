<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index() {
        return \redirect('/home');

        return \view("auth.login");
    }

    public function login(Request $request) {
        if($request->password=='1234'){
            return \redirect('/home');
        } 
    }
}
