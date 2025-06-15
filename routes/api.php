<?php

use App\Http\Controllers\api\auth\AuthController;
use App\Http\Controllers\api\Jobs\JobsController;
use App\Http\Middleware\AuthApiApplicant;
use App\Http\Middleware\AuthApiChecker;
use App\Http\Middleware\AuthApiRecruiter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/login-with-google', [AuthController::class, 'login_with_google']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware(AuthApiChecker::class)->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
    
    Route::prefix('recruiter')->middleware(AuthApiRecruiter::class)->group(function() {
        Route::prefix('/jobs')->group(function() {
            Route::get('/', [JobsController::class, 'list_job_reqruiter']);
            Route::get('/{id}/detail', [JobsController::class, 'detail_job']);
            Route::post('/create', [JobsController::class, 'add_job']);
        });
    });

    Route::prefix('applicant')->middleware(AuthApiApplicant::class)->group(function() {
        Route::prefix('/jobs')->group(function() {
            Route::get('/', [JobsController::class, 'list_job_applicant']);
            Route::get('/{id}/detail', [JobsController::class, 'detail_job']);
            Route::post('/bookmark', [JobsController::class, 'bookmark_job']);
            Route::post('/apply', [JobsController::class, 'apply_job']);
        });
    });
});

