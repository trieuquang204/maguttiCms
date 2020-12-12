<?php

use Illuminate\Http\Request;
use App\maguttiCms\Api\V1\Controllers\NewsController;
use App\maguttiCms\Api\V1\Controllers\UserController;
use App\maguttiCms\Api\V1\Controllers\ArticlesController;

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

Route::group(['prefix' => 'v1'], function () {
    Route::get('article',[ArticlesController::class,'index']);
    Route::get('article/{id}', [ArticlesController::class,'show']);
    Route::get('news',[NewsController::class,'index']);
    Route::get('news/{slug}', [NewsController::class,'show']);
    Route::post('user',[UserController::class,'create']);
});
