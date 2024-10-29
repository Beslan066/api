<?php

use App\Http\Controllers\Admin\Api\v1\PostController;
use App\Http\Controllers\Admin\Api\v1\RoleController;
use App\Http\Controllers\Admin\Api\v1\UserController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::resource('posts', PostController::class,)->middleware('jwt.auth');
Route::resource('roles', RoleController::class,);
Route::resource('users', UserController::class,);


Route::group(['middleware' => 'api', 'prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
});
