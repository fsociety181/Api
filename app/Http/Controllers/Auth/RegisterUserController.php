<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\ValidUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterUserController extends ApiController
{
    public function register(ValidUserRequest $request)
    {
        $user = User::create(
            $request->only('name', 'email') +
            ['password' => Hash::make($request->get('password'))]
        );

        $user->assignRole('user');
        $user->givePermissionTo(['reading', 'like', 'WriteComment']);

        if (is_null($user)) {
            return $this->sendError($user, 400);
        }

        return $this->sendResponse($user, 201);
    }
}
