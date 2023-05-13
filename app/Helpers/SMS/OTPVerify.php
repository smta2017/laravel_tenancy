<?php

namespace App\Helpers\SMS;

use App\Helpers\CURL;
use Illuminate\Http\Request;

class OTPVerify
{
    public static function sendOTP(Request $request)
    {
        $VIA = 'sms';
        $phone = $request["phone"];
        $countryCode = $request["country_code"];

        $options = [
            CURLOPT_URL => 'https://api.authy.com/protected/json/phones/verification/start',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => "via=$VIA&phone_number=$phone&country_code=$countryCode&locale='en'&code_length=6",
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => [
                'X-Authy-Api-Key: V5j0gNwPJQuI97V0qI5MJTMOBhNVTu13',
                'Content-Type: application/x-www-form-urlencoded',
            ]
        ];

        return CURL::sendCurl($options);
    }

    public static function verifyOTP(Request $request)
    {

        $USER_PHONE = $request['phone'];
        $COUNTRY_CODE = $request['country_code'];
        $VERIFICATION_CODE = $request->otp;

        $options = [
            CURLOPT_URL => 'https://api.authy.com/protected/json/phones/verification/check',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => "phone_number=$USER_PHONE&country_code=$COUNTRY_CODE&verification_code=$VERIFICATION_CODE",
            CURLOPT_CUSTOMREQUEST=> 'GET',
            CURLOPT_HTTPHEADER => [
                'X-Authy-Api-Key: V5j0gNwPJQuI97V0qI5MJTMOBhNVTu13',
                'Content-Type: application/x-www-form-urlencoded',
            ]
        ];

        return CURL::sendCurl($options);
    }
}
