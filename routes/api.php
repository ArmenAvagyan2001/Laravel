<?php

use App\Http\Controllers\Admin\EmailTemplatesController;
use App\Http\Controllers\Admin\UsersEmailTemplatesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\PostsController;
use App\Http\Controllers\Admin\UserController;
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
//    Route::resource('users', UserController::class);
//    Route::post('logout', [AuthController::class, 'logout']);
//    Route::resource('posts', PostsController::class);
//});

Route::group(['prefix' => 'admin', 'middleware' => ['auth:sanctum', 'Admin']], function () {
    Route::resource('users', UserController::class);
    Route::resource('email_templates', EmailTemplatesController::class);
    Route::resource('users_email_templates', UsersEmailTemplatesController::class);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::resource('posts', PostsController::class);
});

Route::group(['prefix' => 'client', 'middleware' => ['auth:sanctum', 'client']], function () {
    Route::post('logout', [AuthController::class, 'logout']);
});
