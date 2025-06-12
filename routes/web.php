<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;


Route::get('/artisan-master', function () {
    Artisan::call('vendor:publish', [
        '--provider' => 'L5Swagger\L5SwaggerServiceProvider'
    ]);
});
Route::get('/artisan', function () {
    Artisan::call('l5-swagger:generate');
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/get_token_google', function () {
    return view('get_token_google');
});
