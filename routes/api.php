<?php

use App\Http\Controllers\api\auth\AuthController;
use App\Http\Controllers\api\Applicant\JobController as ApplicantJobController;
use App\Http\Controllers\api\Recruiter\JobController as RecruiterJobController;
use App\Http\Controllers\api\Masterdata\SkillController;
use App\Http\Controllers\api\Masterdata\EmploymentTypeController;
use App\Http\Controllers\api\Masterdata\ExperienceController;
use App\Http\Controllers\api\Masterdata\ExpectedSalaryController;
use App\Http\Controllers\api\Masterdata\EducationController;
use App\Http\Controllers\api\Applicant\ProfileController;
use App\Http\Controllers\api\Assessment\AssessmentController;
use App\Http\Controllers\api\Location\LocationController;
use App\Http\Controllers\api\Applicant\ActivityController;
use App\Http\Controllers\api\Applicant\ExplorController as ApplicantExplorController;
use App\Http\Controllers\api\Masterdata\BadgeController;
use App\Http\Controllers\api\Masterdata\IndustryTypeController;
use App\Http\Controllers\api\Notification\NotificationController;
use App\Http\Controllers\api\Recruiter\ExplorController;
use App\Http\Controllers\api\Recruiter\ProfileController as RecruiterProfileController;
use App\Http\Controllers\api\Video\VideoController;
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
            Route::get('/activity', [RecruiterJobController::class, 'activity']);
            Route::post('/create', [RecruiterJobController::class, 'add_job']);
            Route::post('/update', [RecruiterJobController::class, 'update_job']);
            Route::get('/get-by-id', [RecruiterJobController::class, 'get_job_by_id']);
            Route::get('/get-applicant-by-job-id', [RecruiterJobController::class, 'get_applicant_by_job_id']);
            Route::post('/update-status', [RecruiterJobController::class, 'update_status_job']);
            Route::post('/delete', [RecruiterJobController::class, 'delete_job']);
            Route::get('/get-applicant-detail-by-id', [RecruiterJobController::class, 'get_applicant_detail_by_id']);
            Route::post('/update-applicant-apply-status', [RecruiterJobController::class, 'update_applicant_apply_status']);
            Route::get('/search', [RecruiterJobController::class, 'search_applicant']);
            Route::get('/top_applicant', [RecruiterJobController::class, 'top_applicant']);
            Route::get('/job_applier', [RecruiterJobController::class, 'job_applier']);
        });

        Route::prefix('/explor')->group(function () {
            Route::get('/', [ExplorController::class, 'explode']);
        });

        Route::prefix('/profile')->group(function () {
            Route::get('/', [RecruiterProfileController::class, 'getProfile']);
            Route::post('/', [RecruiterProfileController::class, 'updateProfile']);
        });


        Route::prefix('/notification')->group(function () {
            Route::get('/', [NotificationController::class, 'recruiter']);
        });
    });

    Route::prefix('applicant')->middleware(AuthApiApplicant::class)->group(function () {
        Route::prefix('/jobs')->group(function () {
            Route::get('/ontrending', [ApplicantJobController::class, 'on_trending_jobs']);
            Route::get('/filter-option', [ApplicantJobController::class, 'filter_jobs']);
            Route::get('/recommendations', [ApplicantJobController::class, 'recommendation_job']);
            Route::post('/apply', [ApplicantJobController::class, 'apply_job']);
            Route::get('/get-job-by-id', [ApplicantJobController::class, 'get_job_by_id']);
            Route::get('/search', [ApplicantJobController::class, 'search_job']);
        });

        Route::prefix('/activity')->group(function () {
            Route::post('/bookmark_job', [ActivityController::class, 'bookmark_job']);
            Route::post('/bookmark_company', [ActivityController::class, 'bookmark_company']);
            Route::prefix('/saved')->group(function () {
                Route::get('/job', [ActivityController::class, 'get_bookmark_job']);
                Route::get('/company', [ActivityController::class, 'get_bookmark_company']);
            });
        });

        Route::prefix('/explor')->group(function () {
            Route::get('/', [ApplicantExplorController::class, 'explode']);
        });

        Route::prefix('/profile')->group(function () {
            Route::get('/', [ProfileController::class, 'get_profile']);
            Route::post('/update', [ProfileController::class, 'update_profile']);
            Route::post('/complete_profile', [ProfileController::class, 'update_advance_profile']);
        });

        Route::prefix('assessment')->group(function () {
            Route::get('/', [AssessmentController::class, 'index']);
            Route::post('/answer', [AssessmentController::class, 'answer']);
            Route::put('/score', [AssessmentController::class, 'update']);
        });

        Route::prefix('/notification')->group(function () {
            Route::get('/', [NotificationController::class, 'applicant']);
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
        Route::get('/industry-types', [IndustryTypeController::class, 'index']);

        Route::prefix('/badge')->group(function () {
            Route::get('/applicant', [BadgeController::class, 'applicant']);
            Route::get('/recruiter', [BadgeController::class, 'recruiter']);
        });
    });


    Route::prefix('/video')->group(function () {
        Route::post('/', [VideoController::class, 'store']);
    });
});
