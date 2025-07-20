<?php

use App\Http\Controllers\api\Location\LocationController;
use App\Http\Controllers\Recruiter\RecruiterController;
use App\Http\Controllers\Applicant\ApplicantController;
// use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::redirect("/", "/dashboard");

Route::prefix('dashboard')->group(function () {
    Route::get('/', function () {
        return view('pages.dashboard.index');
    })->name('dashboard');

    Route::prefix('applicants')->group(function () {
        Route::get('/', [ApplicantController::class, "index"])->name('applicants');
        Route::get('/{id}/detail', [ApplicantController::class, "show"])->name('applicants.detail');
    });

    Route::prefix('recruiters')->group(function () {
        Route::get('/', [RecruiterController::class, 'index'])->name('recruiters');
        Route::get('/{id}/detail', [RecruiterController::class, 'detail'])->name('recruiters.detail');
        Route::put('/{id}/update', [RecruiterController::class, 'update'])->name('recruiters.update');
    });

    Route::prefix('jobs')->group(function () {
        Route::get('/', function () {
            return view('pages.jobs.index');
        })->name('jobs');
        Route::get('/detail', function () {
            return view('pages.jobs.detail');
        })->name('jobs.detail');
    });

    Route::prefix('accounts')->group(function () {
        Route::get('/', function () {
            return view('pages.accounts.index');
        })->name('accounts');
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

// require __DIR__ . '/auth.php';
