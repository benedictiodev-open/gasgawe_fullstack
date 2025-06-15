<?php

use Illuminate\Support\Facades\Route;

Route::redirect("/", "/dashboard");

Route::prefix('dashboard')->group(function () {
    Route::get('/', function () {
        return view('pages.dashboard.index');
    })->name('dashboard');
    Route::get('/applicants', function () {
        return view('pages.applicants.index');
    })->name('applicants');
    Route::get('/recruiters', function () {
        return view('pages.recruiters.index');
    })->name('recruiters');
    Route::get('/jobs', function () {
        return view('pages.jobs.index');
    })->name('jobs');
});

Route::get('/get_token_google', function () {
    return view('get_token_google');
});
