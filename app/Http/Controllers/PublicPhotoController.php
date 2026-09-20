<?php

namespace App\Http\Controllers;

use App\Models\GeneratedImage;
use App\Services\GoogleDriveService;

class PublicPhotoController extends Controller
{
    public function show(string $token)
    {
        $image = GeneratedImage::where('public_token', $token)
            ->where('generation_status', 'success')
            ->firstOrFail();

        return view('photobooth.public-photo', [
            'image' => $image,
        ]);
    }

    public function download(
        string $token,
        GoogleDriveService $googleDrive
    ) {
        $image = GeneratedImage::where('public_token', $token)
            ->where('generation_status', 'success')
            ->firstOrFail();

        if (empty($image->google_drive_file_id)) {
            abort(404, 'Photo file is not available.');
        }

        $temporaryPath = storage_path(
            'app/temp/public_' . $image->public_token . '.png'
        );

        try {
            $googleDrive->downloadFile(
                $image->google_drive_file_id,
                $temporaryPath
            );

            return response()
                ->download(
                    $temporaryPath,
                    'RUPAVUE-' . $image->image_uid . '.png',
                    [
                        'Content-Type' => 'image/png',
                    ]
                )
                ->deleteFileAfterSend(true);

        } catch (\Throwable $e) {
            report($e);

            abort(500, 'Unable to download the photo.');
        }
    }
}