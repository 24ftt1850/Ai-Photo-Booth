<?php

namespace App\Http\Controllers;

use App\Models\BoothSetting;
use App\Models\PhotoFrame;
use App\Models\Theme;
use Illuminate\Http\Request;

class PhotoboothController extends Controller
{
    public function create(Request $request)
    {
        $themeId = $request->query('theme_id');

        if (! $themeId) {
            return redirect()
                ->route('photobooth.scene')
                ->with('error', 'Please select a theme first.');
        }

        $theme = Theme::where('id', $themeId)
            ->where('is_active', true)
            ->first();

        if (! $theme) {
            return redirect()
                ->route('photobooth.scene')
                ->with('error', 'The selected theme is no longer available.');
        }

        $photoFrames = PhotoFrame::where('is_active', true)->get();

        /*
         * The frame page skips itself when there are no frames,
         * so only send "Back" there when it will actually show.
         */
        $backUrl = BoothSetting::guestsCanPickFrame() && PhotoFrame::selectable()->exists()
            ? route('photobooth.frame', ['theme_id' => $theme->id])
            : route('photobooth.scene');

        return view('photobooth.create', compact('theme', 'photoFrames', 'backUrl'));
    }

    /**
     * Choose a photo frame after picking a theme. Only active
     * frames stored in Google Drive are offered.
     */
    public function frame(Request $request)
    {
        $theme = Theme::where('id', $request->query('theme_id'))
            ->where('is_active', true)
            ->first();

        if (! $theme) {
            return redirect()
                ->route('photobooth.scene')
                ->with('error', 'Please select a theme first.');
        }

        /*
         * Skipped when the admin site fixes the frame automatically.
         */
        $frames = BoothSetting::guestsCanPickFrame()
            ? PhotoFrame::selectable()->latest('id')->get()
            : collect();

        if ($frames->isEmpty()) {
            return redirect()->route('photobooth.create', ['theme_id' => $theme->id]);
        }

        return view('photobooth.frame', compact('theme', 'frames'));
    }

    public function scene()
    {
        $themes = Theme::where('is_active', true)
            ->orderBy('created_at')
            ->orderBy('id')
            ->get();

        $photoFrames = PhotoFrame::where('is_active', true)->get();

        return view('photobooth.scene', compact('themes', 'photoFrames'));
    }
}
