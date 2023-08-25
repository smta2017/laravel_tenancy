<?php

namespace App\Traits;

use InfyOm\Generator\Utils\ResponseUtil;

trait ResponseTrait
{
    public function sendResponse($result, $message, $code = 200)
    {
        return response()->json(ResponseUtil::makeResponse($message, $result), $code);
    }

    public function sendError($error, $code = 404, $data = [])
    {
        return response()->json(ResponseUtil::makeError($error, $data), $code);
    }

    public function sendSuccess($message)
    {
        return response()->json([
            'success' => true,
            'message' => $message
        ], 200);
    }
}
