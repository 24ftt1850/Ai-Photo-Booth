<?php

use App\Http\Controllers\GeminiController;
use App\Http\Controllers\GoogleDriveController;
use App\Http\Controllers\PhotoboothController;
use App\Http\Controllers\PhotoboothFeedbackController;
use App\Http\Controllers\PhotoboothPrintController;
use App\Http\Controllers\PublicPhotoController;
use App\Models\GeneratedImage;
use App\Models\PhotoFrame;
use App\Models\Theme;
use App\Services\GoogleDriveService;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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
| QR-Scanned Photo View / Download
|--------------------------------------------------------------------------
*/

Route::get('/photobooth/photo/{generatedImage}', function (GeneratedImage $generatedImage) {

    $imageUrl = Storage::url($generatedImage->generated_photo_path);

    return view('photobooth.photo', compact('generatedImage', 'imageUrl'));

})->name('photobooth.photo');

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
     * First visit: show the one-time setup page
     * before the welcome page.
     */
    if (! request()->cookie('rupavue_setup_complete')) {
        return redirect()->route('setup');
    }

    $photoFrames = PhotoFrame::where('is_active', true)->get();

    return view('welcome', compact('photoFrames'));

})->name('home');

/*
|--------------------------------------------------------------------------
| One-time Setup (IP address + event)
|--------------------------------------------------------------------------
| Shown once, before the welcome page. The IP address and event
| are not saved or used yet; completing setup only remembers,
| with a long-lived cookie, that it has been done.
*/

Route::get('/setup', function () {

    return view('photobooth.setup');

})->name('setup');

Route::post('/setup', function () {

    return redirect()
        ->route('home')
        ->withCookie(cookie()->forever('rupavue_setup_complete', '1'));

})->name('setup.complete');

/*
|--------------------------------------------------------------------------
| PHOTO FRAME TEST
|--------------------------------------------------------------------------
|
| Temporary diagnostic route.
|
*/

Route::get('/test-frame', function () {

    $frame = PhotoFrame::where('is_active', true)
        ->latest('id')
        ->first();

    if (! $frame) {
        return 'NO ACTIVE FRAME FOUND';
    }

    return response()->json([

        'id' => $frame->id,

        'name' => $frame->frame_name,

        'path' => $frame->frame_path,

        'url' => asset('storage/'.$frame->frame_path),

        'exists' => \Storage::disk('public')
            ->exists($frame->frame_path),

        'full_path' => \Storage::disk('public')
            ->path($frame->frame_path),

    ]);

});

Route::get(
    '/photo/{token}',
    [PublicPhotoController::class, 'show']
)->name('public.photo.show');

Route::get(
    '/photo/{token}/download',
    [PublicPhotoController::class, 'download']
)->name('public.photo.download');

/*
|--------------------------------------------------------------------------
| Google Drive
|--------------------------------------------------------------------------
*/

Route::get(
    '/google-drive/connect',
    [GoogleDriveController::class, 'connect']
)->name('google-drive.connect');

Route::get(
    '/google-drive/callback',
    [GoogleDriveController::class, 'callback']
)->name('google-drive.callback');

Route::get(
    '/google-drive/test',
    [GoogleDriveController::class, 'test']
)->name('google-drive.test');

Route::get(
    '/google-drive/upload-test',
    [GoogleDriveController::class, 'uploadTest']
)->name('google-drive.upload-test');

Route::get(
    '/google-drive/service-test',
    function (GoogleDriveService $googleDrive) {

        try {

            $testFilePath = storage_path(
                'app/google/rupavue-service-test.png'
            );

            /*
             * Create a simple 500x500 PNG.
             */
            $image = imagecreatetruecolor(500, 500);

            $background = imagecolorallocate(
                $image,
                30,
                35,
                50
            );

            $white = imagecolorallocate(
                $image,
                255,
                255,
                255
            );

            imagefill(
                $image,
                0,
                0,
                $background
            );

            imagestring(
                $image,
                5,
                150,
                240,
                'RUPAVUE TEST',
                $white
            );

            imagepng(
                $image,
                $testFilePath
            );

            imagedestroy($image);

            /*
             * Upload PNG to Google Drive.
             */
            $result = $googleDrive->uploadImage(
                $testFilePath,
                'RUPAVUE-Service-Test-'.
                    now()->format('Ymd-His').
                    '.png'
            );

            return response()->json([
                'success' => true,
                'message' => 'GoogleDriveService upload successful.',

                'file' => $result,
            ]);

        } catch (Throwable $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
)->name('google-drive.service-test');
