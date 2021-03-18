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
        Route::post('comment', [\App\Http\Controllers\CommentController::class, 'store']);
    }
);

Route::group(
    ['middleware' => ['role:admin', 'auth:api']],
    function () {
        Route::apiResource('article', ArticleController::class);
    }
);




