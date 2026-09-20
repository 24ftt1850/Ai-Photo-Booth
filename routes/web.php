<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\GeminiController;
use App\Http\Controllers\GoogleDriveController;
use App\Http\Controllers\PhotoboothFeedbackController;
use App\Models\Theme;
use App\Models\PhotoFrame;
use App\Models\GeneratedImage;
use App\Http\Controllers\PublicPhotoController;
use App\Http\Controllers\PhotoboothController;


/*
|--------------------------------------------------------------------------
| Public / Guest Photobooth
|--------------------------------------------------------------------------
*/

Route::get('/photobooth', [PhotoboothController::class, 'create'])
    ->name('photobooth.create');

Route::get('/photobooth/scene', [PhotoboothController::class, 'scene'])
    ->name('photobooth.scene');


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
| Welcome Page
|--------------------------------------------------------------------------
*/

Route::get('/', function () {

    $photoFrames = PhotoFrame::where('is_active', true)->get();

    return view('welcome', compact('photoFrames'));

})->name('home');


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

    if (!$frame) {
        return 'NO ACTIVE FRAME FOUND';
    }

    return response()->json([

        'id' => $frame->id,

        'name' => $frame->frame_name,

        'path' => $frame->frame_path,

        'url' => asset('storage/' . $frame->frame_path),

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
    function (\App\Services\GoogleDriveService $googleDrive) {

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
                'RUPAVUE-Service-Test-' .
                    now()->format('Ymd-His') .
                    '.png'
            );


            return response()->json([
                'success' => true,
                'message' =>
                    'GoogleDriveService upload successful.',

                'file' => $result,
            ]);

        } catch (\Throwable $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
)->name('google-drive.service-test');