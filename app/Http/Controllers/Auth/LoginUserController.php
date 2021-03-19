<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;

class LoginUserController extends ApiController
{
    public function login(Request $request)
    {
        if (\Auth::attempt($request->only('email', 'password'))) {
            $user = \Auth::user();

            $token = $user->createToken('')->accessToken;

            return [
                'token' => $token,
            ];
        }


        return $this->sendError('Unauthorize', 404);
    }
}
