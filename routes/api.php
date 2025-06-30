<?php

use App\Http\Controllers\api\auth\AuthController;
use App\Http\Controllers\api\Jobs\JobsController;
use App\Http\Controllers\api\Applicant\JobController;
use App\Http\Controllers\api\Masterdata\SkillController;
use App\Http\Controllers\api\Masterdata\EmploymentTypeController;
use App\Http\Controllers\api\Masterdata\ExperienceController;
use App\Http\Controllers\api\Masterdata\ExpectedSalaryController;
use App\Http\Controllers\api\Masterdata\EducationController;
use App\Http\Controllers\api\Applicant\ProfileController;
use App\Http\Controllers\api\Location\LocationController;
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

    Route::prefix('recruiter')->middleware(AuthApiRecruiter::class)->group(function () {
        Route::prefix('/jobs')->group(function () {
            Route::get('/', [JobsController::class, 'list_job_reqruiter']);
            Route::get('/{id}/detail', [JobsController::class, 'detail_job']);
            Route::post('/create', [JobsController::class, 'add_job']);
        });
    });

    Route::prefix('applicant')->middleware(AuthApiApplicant::class)->group(function () {
        Route::prefix('/jobs')->group(function () {
            // Route::get('/', [JobsController::class, 'list_job_applicant']);
            // Route::get('/{id}/detail', [JobsController::class, 'detail_job']);
            // Route::post('/bookmark', [JobsController::class, 'bookmark_job']);
            // Route::post('/apply', [JobsController::class, 'apply_job']);
            Route::get('/ontrending', [JobController::class, 'on_trending_jobs']);
            Route::get('/filter-option', [JobController::class, 'filter_jobs']);
            Route::get('/recommendations', [JobController::class, 'recommendation_job']);
        });
        
        Route::prefix('/profile')->group(function () {
            Route::get('/', [ProfileController::class, 'get_profile']);
            Route::post('/update', [ProfileController::class, 'update_profile']);
            Route::post('/complete_profile', [ProfileController::class, 'update_advance_profile']);
        });
    });

    Route::prefix('masterdata')->group(function () {
        Route::get('/skill', [SkillController::class, 'skill']);
        Route::get('/province', [LocationController::class, 'allProvinces']);
        Route::get('/cities/{id}', [LocationController::class, 'getCitiesByProvinceId']);
        Route::get('/employment-types', [EmploymentTypeController::class, 'index']);
        Route::post('/employment-types', [EmploymentTypeController::class, 'store']);
        Route::get('/experiences', [ExperienceController::class, 'index']);
        Route::post('/experiences', [ExperienceController::class, 'store']);
        Route::get('/expected-salaries', [ExpectedSalaryController::class, 'index']);
        Route::post('/expected-salaries', [ExpectedSalaryController::class, 'store']);
        Route::get('/educations', [EducationController::class, 'index']);
        Route::post('/educations', [EducationController::class, 'store']);
    });
});
