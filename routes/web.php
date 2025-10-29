<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('sites', SiteController::class);

Route::get('/sites/{site}/check', [SiteController::class, 'check'])->name('sites.check');
