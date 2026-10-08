<?php

namespace App\Http\Controllers;

use App\Models\GeneratedImage;
use App\Services\GoogleDriveService;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\ErrorCorrectionLevel;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PublicPhotoController extends Controller
{
    public function show(string $token): View
    {
        $image = GeneratedImage::where('public_token', $token)
            ->where('generation_status', 'success')
            ->firstOrFail();

        return view('photobooth.public-photo', [
            'image' => $image,
        ]);
    }

    /**
     * PNG QR code that opens the guest's photo.
     */
    public function qrCode(string $token): Response
    {
        $image = GeneratedImage::where('public_token', $token)
            ->where('generation_status', 'success')
            ->firstOrFail();

        $qrCode = (new Builder(
            data: $image->publicPhotoUrl(),
            errorCorrectionLevel: ErrorCorrectionLevel::High,
            size: 512,
            margin: 10,
            foregroundColor: new Color(0, 63, 66),
        ))->build();

        return response($qrCode->getString(), 200, [
            'Content-Type' => $qrCode->getMimeType(),
            'Cache-Control' => 'public, max-age=86400',
        ]);
    }

    public function download(
        string $token,
        GoogleDriveService $googleDrive
    ): BinaryFileResponse|StreamedResponse {
        $image = GeneratedImage::where('public_token', $token)
            ->where('generation_status', 'success')
            ->firstOrFail();

        $downloadName = 'RUPAVUE-'.$image->image_uid.'.png';

        if (! empty($image->google_drive_file_id)) {
            $temporaryPath = storage_path(
                'app/temp/public_'.$image->public_token.'.png'
            );

            try {
                $googleDrive->downloadFile(
                    $image->google_drive_file_id,
                    $temporaryPath
                );

                return response()
                    ->download(
                        $temporaryPath,
                        $downloadName,
                        [
                            'Content-Type' => 'image/png',
                        ]
                    )
                    ->deleteFileAfterSend(true);

            } catch (\Throwable $e) {
                report($e);
            }
        }

        /*
         * Google Drive is unavailable (not uploaded or disconnected),
         * so serve the copy kept on this server instead.
         */
        if (
            $image->generated_photo_path &&
            Storage::disk('public')->exists($image->generated_photo_path)
        ) {
            return Storage::disk('public')->download(
                $image->generated_photo_path,
                $downloadName
            );
        }

        abort(404, 'Photo file is not available.');
    }
}
