<?php

namespace App\Http\Controllers;

use App\Models\GeneratedImage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PhotoboothPrintController extends Controller
{
    /**
     * Send a guest's photo to the admin print queue instead of
     * printing it on the guest's own device.
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'generated_image_id' => ['required', 'integer', 'exists:generated_images,id'],
        ]);

        $generatedImage = GeneratedImage::findOrFail($data['generated_image_id']);

        if ($generatedImage->print_status !== 'queued') {
            $generatedImage->update([
                'print_status' => 'queued',
                'print_requested_at' => now(),
                'printed_at' => null,
            ]);
        }

        return response()->json(['success' => true]);
    }
}
