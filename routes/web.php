<?php

use App\Http\Controllers\GeminiController;
use App\Http\Controllers\PhotoboothController;
use App\Http\Controllers\PhotoboothFeedbackController;
use App\Http\Controllers\PhotoboothPrintController;
use App\Http\Controllers\PublicPhotoController;
use App\Models\PhotoFrame;
use App\Models\Theme;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public / Guest Photobooth
|--------------------------------------------------------------------------
*/

Route::get('/photobooth', [PhotoboothController::class, 'create'])
    ->name('photobooth.create');

Route::get('/photobooth/scene', [PhotoboothController::class, 'scene'])
    ->name('photobooth.scene');

Route::get('/photobooth/frame', [PhotoboothController::class, 'frame'])
    ->name('photobooth.frame');

Route::get('/photobooth/generate', function () {

    $themeId = request('theme_id');

    $theme = null;

    if ($themeId) {
        $theme = Theme::find($themeId);
    }

    $photoFrames = PhotoFrame::where('is_active', true)->get();

    return view('photobooth.generate', compact('theme', 'photoFrames'));

})->name('photobooth.generate');

Route::get('/photobooth/result', function () {

    $photoFrames = PhotoFrame::where('is_active', true)->get();

    return view('photobooth.result', compact('photoFrames'));

})->name('photobooth.result');

Route::get('/photobooth/feedback', function () {

    $photoFrames = PhotoFrame::where('is_active', true)->get();

    return view('photobooth.feedback', compact('photoFrames'));

})->name('photobooth.feedback');

/*
|--------------------------------------------------------------------------
| Gemini AI Image Generation
|--------------------------------------------------------------------------
*/

Route::post(
    '/gemini-generate',
    [GeminiController::class, 'generateImage']
)->name('gemini.generate');

/*
|--------------------------------------------------------------------------
| Photobooth Feedback
|--------------------------------------------------------------------------
*/

Route::post(
    '/photobooth/feedback',
    [PhotoboothFeedbackController::class, 'store']
)->name('photobooth.feedback.store');

/*
|--------------------------------------------------------------------------
| Photobooth Print (sent to the admin print queue)
|--------------------------------------------------------------------------
*/

Route::post(
    '/photobooth/print',
    [PhotoboothPrintController::class, 'store']
)->name('photobooth.print.store');

/*
|--------------------------------------------------------------------------
| Welcome Page
|--------------------------------------------------------------------------
*/

Route::get('/', function () {

    /*
     * Opening the link from outside the booth (a clicked link,
     * bookmark or typed URL) shows the setup page first. Coming
     * back to home from inside the booth goes straight to welcome.
     */
    $refererHost = parse_url((string) request()->headers->get('referer'), PHP_URL_HOST);

    if ($refererHost !== request()->getHost()) {
        return redirect()->route('setup');
    }

    $photoFrames = PhotoFrame::where('is_active', true)->get();

    return view('welcome', compact('photoFrames'));

})->name('home');

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
| Where Fortify sends users after logging in. Admin work happens
| on the separate RupaVue admin site, so go back to the booth.
*/

Route::get('/dashboard', function () {

    return redirect()->route('home');

})->middleware('auth')->name('dashboard');

/*
|--------------------------------------------------------------------------
| One-time Setup (IP address + event)
|--------------------------------------------------------------------------
| Shown each time the booth link is opened, before the welcome page.
| The IP address and event are not saved or used yet; completing
| setup just continues to the welcome page.
*/

Route::get('/setup', function () {

    return view('photobooth.setup');

})->name('setup');

Route::post('/setup', function () {

    return redirect()->route('home');

})->name('setup.complete');

Route::get(
    '/photo/{token}',
    [PublicPhotoController::class, 'show']
)->name('public.photo.show');

Route::get(
    '/photo/{token}/download',
    [PublicPhotoController::class, 'download']
)->name('public.photo.download');

Route::get(
    '/photo/{token}/qr',
    [PublicPhotoController::class, 'qrCode']
)->name('public.photo.qr');
