<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GeminiController;
use App\Http\Controllers\PhotoboothFeedbackController;
use App\Models\Theme;


/*
|--------------------------------------------------------------------------
| Public / Guest Photobooth
|--------------------------------------------------------------------------
*/

Route::get('/photobooth', function () {

    $themeId = request('theme_id');

    $theme = null;

    if ($themeId) {
        $theme = Theme::find($themeId);
    }

    return view('photobooth.create', compact('theme'));

})->name('photobooth.create');


Route::get('/photobooth/scene', function () {
    $themes = Theme::where('is_enabled', true)->orderBy('name')->get();

    return view('photobooth.scene', compact('themes'));
})->name('photobooth.scene');


Route::get('/photobooth/generate', function () {
    $themeId = request('theme_id');

    $theme = null;

    if ($themeId) {
        $theme = Theme::find($themeId);
    }

    return view('photobooth.generate', compact('theme'));
})->name('photobooth.generate');


Route::get('/photobooth/result', function () {
    return view('photobooth.result');
})->name('photobooth.result');


Route::get('/photobooth/feedback', function () {
    return view('photobooth.feedback');
})->name('photobooth.feedback');


Route::post(
    '/gemini-generate',
    [GeminiController::class, 'generateImage']
)->name('gemini.generate');


Route::post(
    '/photobooth/feedback',
    [PhotoboothFeedbackController::class, 'store']
)->name('photobooth.feedback.store');


/*
|--------------------------------------------------------------------------
| Welcome Page
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');


Route::get('/access', function () {
    return view('access');
})->name('access');