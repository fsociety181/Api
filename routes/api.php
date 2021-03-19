<?php

use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Auth\LoginUserController;
use App\Http\Controllers\Auth\RegisterUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', [RegisterUserController::class, 'register']);
Route::post('login', [LoginUserController::class, 'login']);

Route::get('article/guest', [ArticleController::class, 'getArticle']);

Route::group(
    ['middleware' => ['permission:reading|like|writeComment', 'role:user|admin', 'auth:api']],
    function () {
        Route::get('user', [\App\Http\Controllers\Api\UserController::class, 'index']);

        Route::put('user', [\App\Http\Controllers\Api\UserController::class, 'updateInfo']);

        Route::patch('user', [\App\Http\Controllers\Api\UserController::class, 'updatePassword']);

        Route::get('like/{article}', [\App\Http\Controllers\Api\LikeController::class, 'store']);

        Route::post('comment', [\App\Http\Controllers\Api\CommentController::class, 'store']);

        Route::get(
            'logout',
            function () {
                return Auth::user()->token()->revoke();
            }
        );
    }
);

Route::group(
    ['middleware' => ['role:admin', 'auth:api']],
    function () {
        Route::apiResource('article', ArticleController::class);
    }
);




