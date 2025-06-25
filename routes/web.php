<?php

use App\Http\Controllers\api\Location\LocationController;
use Illuminate\Support\Facades\Route;

Route::redirect("/", "/dashboard");

Route::prefix('dashboard')->group(function () {
    Route::get('/', function () {
        return view('pages.dashboard.index');
    })->name('dashboard');

    Route::prefix('applicants')->group(function () {
        Route::get('/', function () {
            return view('pages.applicants.index');
        })->name('applicants');
        Route::get('/detail', function () {
            return view('pages.applicants.detail');
        })->name('applicants.detail');
    });

    Route::prefix('recruiters')->group(function () {
        Route::get('/', function () {
            return view('pages.recruiters.index');
        })->name('recruiters');
        Route::get('/detail', function () {
            return view('pages.recruiters.detail');
        })->name('recruiters.detail');
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
Route::get('/cities/{id}', [LocationController::class, 'getCitiesByProvinceId']);
Route::get('/districts/{id}', [LocationController::class, 'getDistrictsByCityId']);
Route::get('/villages/{id}', [LocationController::class, 'getVillagesbyDistrictId']);
