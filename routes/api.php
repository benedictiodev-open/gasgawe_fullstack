<?php

use App\Http\Controllers\api\auth\AuthController;
use App\Http\Controllers\api\Jobs\JobsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/login', [AuthController::class, 'login']);
Route::post('/login-with-google', [AuthController::class, 'login_with_google']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware("auth:sanctum")->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::prefix('recruitment')->group(function() {
    Route::prefix('/jobs')->group(function() {
        Route::get('/', [JobsController::class, 'list_job']);
    });
});
