<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserUpdateInfoRequest;
use App\Http\Requests\UserUpdatePassword;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends ApiController
{
    public function index()
    {
        $user = \Auth::user();

        if (is_null($user)) {
            return $this->sendError($user, 401);
        }

        return $this->sendResponse($user, 200);
    }

    public function updateInfo(UserUpdateInfoRequest $request)
    {
        $user = \Auth::user();

        $user->update($request->only('name', 'email'));

        if (is_null($user)) {
            return $this->sendError($user, 400);
        }

        return $this->sendResponse($user, 202);
    }

    public function updatePassword(UserUpdatePassword $request)
    {
        $user = Auth::user();

        $user->update(
            [
                'password' => Hash::make($request->get('password')),
            ]
        );

        if (is_null($user)) {
            return $this->sendError($user, 400);
        }

        return $this->sendResponse($user, 202);
    }

    public function logout()
    {
        $logout = Auth::user()->token()->revoke();

        return $this->sendResponse($logout, 200);
    }
}
