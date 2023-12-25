<?php

use App\Http\Controllers\Api\v1\AuthorApiController;
use App\Http\Controllers\Api\v1\BookApiController;
use App\Http\Controllers\Api\v1\LoanApiController;
use App\Http\Controllers\Api\v1\UserApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\Api\v1'], function () {
    Route::apiResource('books', BookApiController::class);
    Route::apiResource('authors', AuthorApiController::class);
    Route::apiResource('loans', LoanApiController::class);
    Route::apiResource('users', UserApiController::class);

    Route::post('books/bulk', [BookApiController::class, 'bulkStore']);
    Route::post('users/tokens', [UserApiController::class, 'tokenCreate']);
});
