<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GeneratedImage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PrintQueueController extends Controller
{
    public function index(): View
    {
        $queuedPrints = GeneratedImage::where('print_status', 'queued')
            ->oldest('print_requested_at')
            ->get();

        $recentlyPrinted = GeneratedImage::where('print_status', 'printed')
            ->latest('printed_at')
            ->take(12)
            ->get();

        return view('admin.prints.index', compact('queuedPrints', 'recentlyPrinted'));
    }

    /**
     * Lightweight list of queued print orders, polled by the admin
     * print page so a new guest order triggers printing right away.
     */
    public function pending(): JsonResponse
    {
        $queuedIds = GeneratedImage::where('print_status', 'queued')
            ->oldest('print_requested_at')
            ->pluck('id');

        return response()->json(['queued_ids' => $queuedIds]);
    }

    public function markPrinted(GeneratedImage $generatedImage): RedirectResponse
    {
        $generatedImage->update([
            'print_status' => 'printed',
            'printed_at' => now(),
        ]);

        return back()->with('status', 'Photo marked as printed.');
    }

    public function destroy(GeneratedImage $generatedImage): RedirectResponse
    {
        $generatedImage->update([
            'print_status' => null,
            'print_requested_at' => null,
        ]);

        return back()->with('status', 'Print request removed.');
    }
}
