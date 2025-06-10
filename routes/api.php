<?php

use App\Http\Controllers\api\auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware("auth:sanctum")->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
