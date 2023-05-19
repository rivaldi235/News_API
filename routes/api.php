<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\CommentController;



Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/roles', [RoleController::class, 'create']);
Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/{id}', [PostController::class, 'show']);


Route::middleware('auth:api')->group(function() {
    Route::get('profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/posts', [PostController::class, 'store'])->middleware('role-admin');
    Route::post('/posts/{id}', [PostController::class, 'update'])->middleware('role-admin');
    Route::delete('posts/{id}', [PostController::class, 'destroy'])->middleware('role-admin');

    Route::post('/comments', [CommentController::class, 'store']);
});