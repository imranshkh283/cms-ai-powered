<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ArticleController;

// Public routes of authtication
Route::post('/login', [AuthController::class, 'index'])->name('login');

// Resource routes of category
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::post('/categories/create', [CategoryController::class, 'create']);
    Route::patch('/categories/{id}', [CategoryController::class, 'update']);
    Route::delete('/categories/{id}', [CategoryController::class, 'delete']);

    Route::get('/articles', [ArticleController::class, 'index']);
    Route::post('/articles/create', [ArticleController::class, 'create']);
    Route::patch('/articles/{id}', [ArticleController::class, 'update']);
    Route::delete('/articles/{id}', [ArticleController::class, 'delete']);
});

// Protected routes of product and logout
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::get('/test-api', function () {
    return response()->json(['message' => 'API is working']);
});
