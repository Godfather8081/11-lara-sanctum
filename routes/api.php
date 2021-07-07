<?php

use App\Http\Controllers\post\PostController;
use App\Http\Controllers\user\UserController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



// open routes
Route::post('register', [UserController::class, 'registerUser']);
Route::post('login', [UserController::class, 'loginUser']);
Route::get('posts', [PostController::class, 'index']);

// protected urls
Route::middleware(['auth:sanctum'])->group(function () {

    Route::post('logout', [UserController::class, 'logoutUser']);

    Route::post('posts', [PostController::class, 'store']);
});
