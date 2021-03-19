<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    public function sendResponse($result, $code)
    {
        $response = [
            'success' => true,
            'data' => $result
        ];

        return response()->json($response, $code);
    }

    public function sendError($errorMessage, $code)
    {
        $response = [
            'success' => false,
        ];

        if (!empty($errorMessage)) {
            $response['data'] = $errorMessage;
        }

        return response()->json($response, $code);
    }
}
