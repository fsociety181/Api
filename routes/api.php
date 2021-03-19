<?php

use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Auth\LoginUserController;
use App\Http\Controllers\Auth\RegisterUserController;
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

Route::prefix('articles')->group(
    function () {
        Route::get('/', [ArticleController::class, 'index']);
        Route::get('/{article}', [ArticleController::class, 'show']);
    }
);

Route::group(
    ['middleware' => ['permission:reading|like|writeComment', 'role:user|admin', 'auth:api']],
    function () {
        Route::get('user', [\App\Http\Controllers\Api\UserController::class, 'index']);

        Route::put('user', [\App\Http\Controllers\Api\UserController::class, 'updateInfo']);

        Route::patch('user', [\App\Http\Controllers\Api\UserController::class, 'updatePassword']);

        Route::get('like/{article}', [\App\Http\Controllers\Api\LikeController::class, 'store']);

        Route::post('comment', [\App\Http\Controllers\Api\CommentController::class, 'store']);

        Route::get('logout', [\App\Http\Controllers\Api\UserController::class, 'logout']);
    }
);

Route::group(
    [
        'middleware' => ['role:admin', 'auth:api'],
        'prefix' => 'articles',
    ],
    function () {
        Route::post('/', [ArticleController::class, 'store']);

        Route::put('/', [ArticleController::class, 'update']);

        Route::delete('/{article}', [ArticleController::class, 'destroy']);
    }
);




