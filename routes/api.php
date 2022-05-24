<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminPostsController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Models\User;
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


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::get('verify-email', [AuthController::class, 'verify']);

//Route::middleware('auth:sanctum')->group( function () {
//    Route::resource('users', AdminUserController::class);
//    Route::post('logout', [AuthController::class, 'logout']);
//    Route::resource('posts', AdminPostsController::class);
//});

Route::group(['middleware' => ['auth:sanctum', 'admin']], function () {
    Route::resource('users', AdminUserController::class);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::resource('posts', AdminPostsController::class);
});

Route::group(['middleware' => ['auth:sanctum', 'client']], function () {
    Route::post('logout', [AuthController::class, 'logout']);
});
