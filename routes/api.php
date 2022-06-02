<?php

use App\Http\Controllers\Admin\EmailTemplatesController;
use App\Http\Controllers\Admin\UserPostLikedController;
use App\Http\Controllers\Admin\UsersEmailTemplatesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\PostsController;
use App\Http\Controllers\Admin\UserController;
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

Route::group(['prefix' => 'admin', 'middleware' => ['auth:sanctum', 'admin']], function () {
    // USERS
    Route::get('users', [UserController::class, 'index']);
    Route::put('users/{user}', [UserController::class, 'update']);
    Route::delete('users/{user}', [UserController::class, 'destroy']);
    Route::get('users/{user}', [UserController::class, 'show']);

    // EMAIL_TEMPLATES
    Route::post('email_templates', [EmailTemplatesController::class, 'sendEmail']);

    // USERS_EMAIL_TEMPLATES
    Route::post('users_email_templates', [UsersEmailTemplatesController::class, 'sendEmail']);

    //LOGOUT
    Route::post('logout', [AuthController::class, 'logout']);

    // POSTS
    Route::resource('posts', PostsController::class);

    //LIKE
    Route::post('like', [UserPostLikedController::class, 'like']);
});

Route::group(['prefix' => 'client', 'middleware' => ['auth:sanctum', 'client']], function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::resource('posts', PostsController::class);

    //LIKE
    Route::post('like', [UserPostLikedController::class, 'like']);
});
