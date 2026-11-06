<?php

namespace App\Http\Controllers;

use App\Models\GeneratedImage;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\ErrorCorrectionLevel;
use Illuminate\Http\Response;

class PublicPhotoController extends Controller
{
    /**
     * PNG QR code that opens the guest's photo on Google Drive.
     */
    public function qrCode(string $token): Response
    {
        $image = GeneratedImage::where('public_token', $token)
            ->where('generation_status', 'success')
            ->firstOrFail();

        $photoUrl = $image->publicPhotoUrl();

        abort_if($photoUrl === null, 404, 'Photo is not on Google Drive yet.');

        $qrCode = (new Builder(
            data: $photoUrl,
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
}
