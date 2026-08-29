<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\GeneratedImage;
use App\Models\PhotoSession;
use App\Models\Theme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class GeminiController extends Controller
{
    public function generateImage(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Validate Request
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'image' => 'required|string',
            'theme_id' => 'required|integer|exists:themes,id',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Get Data
        |--------------------------------------------------------------------------
        */

        $imageData = $request->input('image');

        $theme = Theme::findOrFail($request->input('theme_id'));


        /*
        |--------------------------------------------------------------------------
        | Active Event
        |--------------------------------------------------------------------------
        */

        $event = Event::where('status', 'active')->latest()->first();

        if (!$event) {

            return response()->json([
                'success' => false,
                'message' => 'No active event is configured for the photobooth.'
            ], 500);

        }


        /*
        |--------------------------------------------------------------------------
        | Remove Base64 Header
        |--------------------------------------------------------------------------
        */

        if (str_contains($imageData, ',')) {

            $imageData =
                explode(',', $imageData, 2)[1];

        }


        /*
        |--------------------------------------------------------------------------
        | Decode Image
        |--------------------------------------------------------------------------
        */

        $imageBinary =
            base64_decode($imageData);


        if ($imageBinary === false) {

            return response()->json([
                'success' => false,
                'message' => 'Invalid image data.'
            ], 422);

        }


        /*
        |--------------------------------------------------------------------------
        | Save Original Image
        |--------------------------------------------------------------------------
        */

        $fileName =
            'original_' .
            time() .
            '_' .
            uniqid() .
            '.jpg';


        Storage::disk('public')->put(
            'photobooth/' . $fileName,
            $imageBinary
        );


        /*
        |--------------------------------------------------------------------------
        | Theme Prompt
        |--------------------------------------------------------------------------
        */

        $prompt = $theme->prompt;

        if (!$prompt) {

            return response()->json([
                'success' => false,
                'message' => 'This theme has no prompt configured.'
            ], 422);

        }


        /*
        |--------------------------------------------------------------------------
        | Gemini API Key
        |--------------------------------------------------------------------------
        */

        $apiKey =
            env('GEMINI_API_KEY');


        if (!$apiKey) {

            return response()->json([
                'success' => false,
                'message' => 'Gemini API key is not configured.'
            ], 500);

        }


        /*
        |--------------------------------------------------------------------------
        | Gemini Request
        |--------------------------------------------------------------------------
        */

        $response = Http::timeout(120)
            ->withHeaders([
                'Content-Type' =>
                    'application/json',
            ])
            ->post(
                'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash-image:generateContent?key='
                . $apiKey,

                [

                    'contents' => [

                        [

                            'parts' => [

                                [
                                    'text' => $prompt
                                ],

                                [

                                    'inline_data' => [

                                        'mime_type' =>
                                            'image/jpeg',

                                        'data' =>
                                            $imageData,

                                    ],

                                ],

                            ],

                        ],

                    ],

                    'generationConfig' => [

                        'responseModalities' => [
                            'TEXT',
                            'IMAGE'
                        ],

                    ],

                ]
            );


        /*
        |--------------------------------------------------------------------------
        | Check Response
        |--------------------------------------------------------------------------
        */

        if (!$response->successful()) {

            return response()->json([

                'success' => false,

                'message' =>
                    'Gemini image generation failed.',

                'error' =>
                    $response->json(),

            ], 500);

        }


        /*
        |--------------------------------------------------------------------------
        | Find Generated Image
        |--------------------------------------------------------------------------
        */

        $responseData =
            $response->json();


        $generatedImage =
            null;


        $parts =
            data_get(
                $responseData,
                'candidates.0.content.parts',
                []
            );


        foreach ($parts as $part) {

            if (
                isset(
                    $part['inlineData']['data']
                )
            ) {

                $generatedImage =
                    $part['inlineData']['data'];

                break;

            }


            if (
                isset(
                    $part['inline_data']['data']
                )
            ) {

                $generatedImage =
                    $part['inline_data']['data'];

                break;

            }

        }


        /*
        |--------------------------------------------------------------------------
        | No Image
        |--------------------------------------------------------------------------
        */

        if (!$generatedImage) {

            return response()->json([

                'success' => false,

                'message' =>
                    'Gemini did not return an image.',

                'response' =>
                    $responseData,

            ], 500);

        }


        /*
        |--------------------------------------------------------------------------
        | Save Generated Image
        |--------------------------------------------------------------------------
        */

        $generatedBinary =
            base64_decode(
                $generatedImage
            );


        $generatedFileName =
            'generated_' .
            time() .
            '_' .
            uniqid() .
            '.png';


        Storage::disk('public')->put(

            'photobooth/' .
            $generatedFileName,

            $generatedBinary

        );


        /*
        |--------------------------------------------------------------------------
        | Record Session + Generated Image
        |--------------------------------------------------------------------------
        */

        $photoSession = PhotoSession::create([
            'event_id' => $event->id,
            'status' => 'completed',
            'started_at' => now(),
            'ended_at' => now(),
        ]);

        $generatedImage = GeneratedImage::create([
            'photo_session_id' => $photoSession->id,
            'event_id' => $event->id,
            'theme_id' => $theme->id,
            'original_image_path' => 'photobooth/' . $fileName,
            'generated_image_path' => 'photobooth/' . $generatedFileName,
            'status' => 'completed',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Return Result
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'success' => true,

            'theme' =>
                $theme->name,

            'generated_image_id' =>
                $generatedImage->id,

            'original_image' =>
                Storage::url(
                    'photobooth/' .
                    $fileName
                ),

            'generated_image' =>
                Storage::url(
                    'photobooth/' .
                    $generatedFileName
                ),

        ]);

    }
}