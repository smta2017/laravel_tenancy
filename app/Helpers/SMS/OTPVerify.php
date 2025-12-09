<?php

namespace App\Helpers\SMS;

use App\Helpers\CURL;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use Twilio\Rest\Client;

class OTPVerify
{
    use Helper;

    public static function sendOTP(Request $request)
    {
        if (self::TestedEnv()) {
            return ["status" => true, "message" => "ok"];
        }
        $sid    = env('TWILIO_ACCOUNT_SID');
        $token  = env('TWILIO_AUTH_TOKEN');
        $service_sid  = env('TWILIO_SERVICE_SID');
        
        $twilio = new Client($sid, $token);

        try {
            $verification = $twilio->verify->v2->services($service_sid)
                ->verifications
                ->create($request->phone, "sms");
        } catch (\Throwable $th) {
            return ['status' => false, 'message' => $th->getMessage()];
        }

        if (!empty($verification->sid)) {
            return ['status' => true];
        }
    }

    public static function verifyOTP(Request $request)
    {
        if (self::TestedEnv()) {
            return ["status" => true, "message" => "ok"];
        }

        $sid    = env('TWILIO_ACCOUNT_SID');
        $token  = env('TWILIO_AUTH_TOKEN');
        $service_sid  = env('TWILIO_SERVICE_SID');
        $twilio = new Client($sid, $token);

        try {
            $verification_check = $twilio->verify->v2->services($service_sid)
                ->verificationChecks
                ->create(
                    [
                        "to" => $request->phone,
                        "code" => $request->otp
                    ]
                );
        } catch (\Throwable $th) {
            return ['status' => false, 'message' => $th->getMessage()];
        }

        if ($verification_check->status == "approved" && $verification_check->valid) {
            return ['status' => true];
        }
        return ['status' => false];
    }
}
