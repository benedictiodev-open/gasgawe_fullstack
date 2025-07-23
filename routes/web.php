<?php

use App\Http\Controllers\Account\AccountController;
use App\Http\Controllers\api\Location\LocationController;
use App\Http\Controllers\Masterdata\SkillController;
use App\Http\Controllers\Recruiter\RecruiterController;
use App\Http\Controllers\Applicant\ApplicantController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Job\JobController;
use App\Http\Controllers\Masterdata\BadgeController;
use App\Http\Controllers\Masterdata\EducationController;
use App\Http\Controllers\Masterdata\EmploymentTypeController;
use App\Http\Controllers\Masterdata\ExpectedSalaryController;
use App\Http\Controllers\Masterdata\ExperienceController;
use App\Http\Controllers\Masterdata\IndustryTypeController;
// use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::redirect("/", "/login");

Route::prefix('dashboard')->middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/top_chart_dashboard', [DashboardController::class, 'top_chart'])->name('top_chart_dashboard');

    Route::prefix('applicants')->group(function () {
        Route::get('/', [ApplicantController::class, "index"])->name('applicants');
        Route::get('/{id}/detail', [ApplicantController::class, "show"])->name('applicants.detail');
        Route::put('/{id}/update', [ApplicantController::class, 'update'])->name('applicants.update');
    });

    Route::prefix('recruiters')->group(function () {
        Route::get('/', [RecruiterController::class, 'index'])->name('recruiters');
        Route::get('/{id}/detail', [RecruiterController::class, 'detail'])->name('recruiters.detail');
        Route::put('/{id}/update', [RecruiterController::class, 'update'])->name('recruiters.update');
    });

    Route::prefix('jobs')->group(function () {
        Route::get('/', [JobController::class, 'index'])->name('jobs');
        Route::get('/{id}/detail', [JobController::class, 'show'])->name('jobs.detail');
        Route::put('/{id}/update', [JobController::class, 'update'])->name('jobs.update');
    });

    Route::prefix('accounts')->group(function () {
        Route::get('/', [AccountController::class, 'index'])->name('accounts');
        Route::post('/update_data_user', [AccountController::class, 'update_data_user'])->name('update_data_user');
        Route::post('/update_password', [AccountController::class, 'update_password'])->name('update_password');
    });

    Route::prefix('masterdata')->name('masterdata.')->group(function () {
        Route::prefix('/skills')->name('skills.')->group(function () {
            Route::get('/', [SkillController::class, 'index'])->name('index');
            Route::post('/', [SkillController::class, 'store'])->name('store');
            Route::put('/{id}', [SkillController::class, 'update'])->name('update');
            Route::delete('/{id}', [SkillController::class, 'destroy'])->name('delete');
        });

        Route::prefix('/education')->name('education.')->group(function () {
            Route::get('/', [EducationController::class, 'index'])->name('index');
            Route::post('/', [EducationController::class, 'store'])->name('store');
            Route::put('/{id}', [EducationController::class, 'update'])->name('update');
            Route::delete('/{id}', [EducationController::class, 'destroy'])->name('delete');
        });

        Route::prefix('/experience')->name('experience.')->group(function () {
            Route::get('/', [ExperienceController::class, 'index'])->name('index');
            Route::post('/', [ExperienceController::class, 'store'])->name('store');
            Route::put('/{id}', [ExperienceController::class, 'update'])->name('update');
            Route::delete('/{id}', [ExperienceController::class, 'destroy'])->name('delete');
        });

        Route::prefix('/expected-salary')->name('expectedSalary.')->group(function () {
            Route::get('/', [ExpectedSalaryController::class, 'index'])->name('index');
            Route::post('/', [ExpectedSalaryController::class, 'store'])->name('store');
            Route::put('/{id}', [ExpectedSalaryController::class, 'update'])->name('update');
            Route::delete('/{id}', [ExpectedSalaryController::class, 'destroy'])->name('delete');
        });

        Route::prefix('/employment-type')->name('employmentType.')->group(function () {
            Route::get('/', [EmploymentTypeController::class, 'index'])->name('index');
            Route::post('/', [EmploymentTypeController::class, 'store'])->name('store');
            Route::put('/{id}', [EmploymentTypeController::class, 'update'])->name('update');
            Route::delete('/{id}', [EmploymentTypeController::class, 'destroy'])->name('delete');
        });

        Route::prefix('/industry-type')->name('industryType.')->group(function () {
            Route::get('/', [IndustryTypeController::class, 'index'])->name('index');
            Route::post('/', [IndustryTypeController::class, 'store'])->name('store');
            Route::put('/{id}', [IndustryTypeController::class, 'update'])->name('update');
            Route::delete('/{id}', [IndustryTypeController::class, 'destroy'])->name('delete');
        });

        Route::prefix('/badge')->name('badge.')->group(function () {
            Route::get('/', [BadgeController::class, 'index'])->name('index');
            Route::post('/', [BadgeController::class, 'store'])->name('store');
            Route::put('/{id}', [BadgeController::class, 'update'])->name('update');
            Route::delete('/{id}', [BadgeController::class, 'destroy'])->name('delete');
        });
    });
});

Route::get('/get_token_google', function () {
    return view('get_token_google');
});


Route::get('/provinces', [LocationController::class, 'allProvinces']);
Route::get('/cities/{id}', [LocationController::class, 'getCitiesByProvinceId'])->name('city');
Route::get('/districts/{id}', [LocationController::class, 'getDistrictsByCityId']);
Route::get('/villages/{id}', [LocationController::class, 'getVillagesbyDistrictId']);

// Route::get('/', function () {
//     return redirect()->route('dashboard');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__ . '/auth.php';
