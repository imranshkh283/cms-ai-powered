<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

// Public routes of authtication
Route::post('/login', [AuthController::class, 'index'])->name('login');



Route::get('/test-api', function () {
    return response()->json(['message' => 'API is working']);
});
