<?php

namespace App\Http\Controllers;

use App\Models\GeneratedImage;
use Illuminate\Http\Request;

class PhotoboothFeedbackController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'generated_image_id' => ['required', 'integer', 'exists:generated_images,id'],
            'rating' => ['required', 'integer', 'between:1,5'],
            'feedback' => ['nullable', 'string', 'max:255'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ]);

        $generatedImage = GeneratedImage::findOrFail($data['generated_image_id']);

        $feedbackComment = collect([$data['feedback'] ?? null, $data['comment'] ?? null])
            ->filter()
            ->implode(' — ');

        $generatedImage->update([
            'satisfaction_rating' => $data['rating'],
            'feedback_comment' => $feedbackComment !== '' ? $feedbackComment : null,
        ]);

        return response()->json(['success' => true]);
    }
}
