<?php

namespace App\Http\Controllers;

use App\Models\GeneratedImage;
use App\Models\PrintOrder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PhotoboothPrintController extends Controller
{
    /**
     * Send a guest's photo to the RupaVue admin site's Print Orders
     * page instead of printing it on the guest's own device.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'generated_image_id' => ['required', 'integer', 'exists:generated_images,id'],
        ]);

        $generatedImage = GeneratedImage::findOrFail($request->integer('generated_image_id'));

        /*
         * A second tap while the photo is still waiting to print
         * must not queue another copy.
         */
        $alreadyQueued = PrintOrder::where('generated_image_id', $generatedImage->id)
            ->where('print_status', 'queued')
            ->exists();

        if ($alreadyQueued) {
            return response()->json(['success' => true]);
        }

        $printConfig = DB::table('print_cost_configs')
            ->where('status', 'Active')
            ->orderByRaw('ai_model_id = ? desc', [$generatedImage->model_id])
            ->orderBy('id')
            ->first(['id', 'ai_model_id']);

        if (! $printConfig) {
            return response()->json([
                'success' => false,
                'message' => 'Printing is not set up yet. Please ask a staff member for help.',
            ], 503);
        }

        DB::transaction(function () use ($generatedImage, $printConfig): void {
            $printOrder = PrintOrder::create([
                'photo_session_id' => $generatedImage->photo_session_id,
                'generated_image_id' => $generatedImage->id,
                'print_config_id' => $printConfig->id,
                'ai_model_id' => $generatedImage->model_id ?? $printConfig->ai_model_id,
                'quantity' => 1,
                'print_status' => 'queued',
            ]);

            /*
             * The insert trigger also charges the image's AI cost again;
             * the photo was already generated, so printing costs no new
             * API call (same as the admin site's reprints).
             */
            DB::table('print_orders')
                ->where('id', $printOrder->id)
                ->update(['unit_api_cost_bnd' => 0]);
        });

        return response()->json(['success' => true]);
    }
}
