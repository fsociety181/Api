<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    public function sendResponse($result, $message, $code)
    {
        $response = [
            'success' => true,
            'message' => $message,
            'data' => $result
        ];

        return response()->json($response, $code);
    }

    public function sendError($error, $errorMessage, $code)
    {
        $response = [
            'success' => false,
            'message' => $error
        ];

        if (!empty($errorMessage)) {
            $response['data'] = $errorMessage;
        }

        return response()->json($response, $code);
    }
}
