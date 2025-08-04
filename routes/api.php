<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\LanguageController;
use App\Http\Controllers\Api\CategoryController;

Route::post('auth/login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('languages', LanguageController::class);
    Route::post('languages/{language}/restore', [languageController::class, 'restore']);
    Route::delete('languages/{language}/force', [LanguageController::class, 'forceDelete']);
    Route::apiResource('categories', CategoryController::class);
    Route::get('categories/export', [CategoryController::class, 'export']);
    Route::post('categories/{category}/restore', [CategoryController::class, 'restore']);
    Route::delete('categories/{category}/force', [CategoryController::class, 'forceDelete']);
});
