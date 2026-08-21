<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GeminiController;
use App\Http\Controllers\AdminController;


/*
|--------------------------------------------------------------------------
| Public / Guest Photobooth
|--------------------------------------------------------------------------
*/

Route::get('/photobooth', function () {
    return view('photobooth.create');
})->name('photobooth.create');


Route::get('/photobooth/scene', function () {
    return view('photobooth.scene');
})->name('photobooth.scene');


Route::get('/photobooth/generate', function () {
    return view('photobooth.generate');
})->name('photobooth.generate');


Route::get('/photobooth/result', function () {
    return view('photobooth.result');
})->name('photobooth.result');


Route::post(
    '/gemini-generate',
    [GeminiController::class, 'generateImage']
)->name('gemini.generate');


/*
|--------------------------------------------------------------------------
| Welcome Page
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});


/*
|--------------------------------------------------------------------------
| Admin Authentication
|--------------------------------------------------------------------------
*/

Route::get(
    '/admin/login',
    [AdminController::class, 'showLogin']
)->name('admin.login');


Route::post(
    '/admin/login',
    [AdminController::class, 'login']
)->name('admin.login.submit');


Route::post(
    '/admin/logout',
    [AdminController::class, 'logout']
)->name('admin.logout');


/*
|--------------------------------------------------------------------------
| Admin Dashboard
|--------------------------------------------------------------------------
*/

Route::get(
    '/admin/dashboard',
    [AdminController::class, 'dashboard']
)
    ->middleware('admin')
    ->name('admin.dashboard');


/*
|--------------------------------------------------------------------------
| Admin Events
|--------------------------------------------------------------------------
*/

Route::get(
    '/admin/events',
    function () {
        return view('admin.events.index');
    }
)
    ->middleware('admin')
    ->name('admin.events.index');


/*
|--------------------------------------------------------------------------
| Admin Themes
|--------------------------------------------------------------------------
*/

Route::get(
    '/admin/themes',
    function () {
        return view('admin.themes.index');
    }
)
    ->middleware('admin')
    ->name('admin.themes.index');


/*
|--------------------------------------------------------------------------
| Admin Analytics
|--------------------------------------------------------------------------
*/

Route::get(
    '/admin/analytics',
    function () {
        return view('admin.analytics.index');
    }
)
    ->middleware('admin')
    ->name('admin.analytics.index');


/*
|--------------------------------------------------------------------------
| Admin Feedback
|--------------------------------------------------------------------------
*/

Route::get(
    '/admin/feedback',
    function () {
        return view('admin.feedback.index');
    }
)
    ->middleware('admin')
    ->name('admin.feedback.index');