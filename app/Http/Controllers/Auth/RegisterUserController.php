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
//        $user->givePermissionTo('like');
//        $user->givePermissionTo('WriteComment');

        if (is_null($user)) {
            return $this->sendError($user, 400);
        }

        if ($user->hasRole('user')) {
            return $this->sendResponse($user, 201);
        } else {
            return 'GG';
        }
    }
}
