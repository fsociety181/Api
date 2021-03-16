<?php

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

Route::get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('article')->group(function (){

    Route::get('/', 'App\Http\Controllers\Api\ArticleController@index');
    Route::get('/{article}', 'App\Http\Controllers\Api\ArticleController@show');
    Route::get('delete/{article}', 'App\Http\Controllers\Api\ArticleController@destroy');

    Route::post('/','App\Http\Controllers\Api\ArticleController@create');
    Route::post('/{article}', 'App\Http\Controllers\Api\ArticleController@update');

});


