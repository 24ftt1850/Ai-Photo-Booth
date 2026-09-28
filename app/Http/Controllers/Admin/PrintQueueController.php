<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GeneratedImage;
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
