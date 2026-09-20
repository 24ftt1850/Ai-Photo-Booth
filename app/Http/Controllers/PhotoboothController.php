<?php

namespace App\Http\Controllers;

use App\Models\PhotoFrame;
use App\Models\Theme;
use Illuminate\Http\Request;

class PhotoboothController extends Controller
{
    public function create(Request $request)
    {
        $themeId = $request->query('theme_id');

        if (!$themeId) {
            return redirect()
                ->route('photobooth.scene')
                ->with('error', 'Please select a theme first.');
        }

        $theme = Theme::where('id', $themeId)
            ->where('is_active', true)
            ->first();

        if (!$theme) {
            return redirect()
                ->route('photobooth.scene')
                ->with('error', 'The selected theme is no longer available.');
        }

        $photoFrames = PhotoFrame::where('is_active', true)->get();

        return view('photobooth.create', compact('theme', 'photoFrames'));
    }

    public function scene()
    {
        $themes = Theme::where('is_active', true)
            ->orderBy('theme_name')
            ->get();

        $photoFrames = PhotoFrame::where('is_active', true)->get();

        return view('photobooth.scene', compact('themes', 'photoFrames'));
    }
}
