<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends AppBaseController
{
    function login(Request $request)
    {
        // Validate the request data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        // Attempt to log in the user using the credentials
        if (Auth::attempt($request->only('email', 'password'))) {
            // Generate a new token for the authenticated user
            $token = $request->user()->createToken('api-token')->plainTextToken;
    
            // Return a JSON response with the token and user details
            return response()->json([
                'token' => $token,
                'user' => $request->user(),
            ]);
        } else {
            // Return an error response if the login attempt failed
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
    }
}
