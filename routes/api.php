<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ArticleController;

// Public routes of authtication
Route::post('/login', [AuthController::class, 'index'])->name('login');

// Resource routes of category
Route::middleware(['auth:sanctum'])->group(function () {

    Route::middleware('admin')->prefix('category')->group(function () {
        Route::get('/', [CategoryController::class, 'index']);
        Route::post('/create', [CategoryController::class, 'create']);
        Route::patch('/{id}', [CategoryController::class, 'update']);
        Route::delete('/{id}', [CategoryController::class, 'delete']);
    });

    Route::get('/articles', [ArticleController::class, 'index']);
    Route::post('/articles/create', [ArticleController::class, 'create']);
    Route::patch('/articles/{id}', [ArticleController::class, 'update']);
    Route::post('/articles/published', [ArticleController::class, 'statusChange']);
    Route::delete('/articles/{id}', [ArticleController::class, 'delete']);
});

// Protected routes of product and logout
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::get('/test-api', function () {
    return response()->json(['message' => 'API is working']);
});
