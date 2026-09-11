<?php

namespace App\Http\Controllers;

use App\Models\GeneratedImage;
use App\Models\PhotoSession;
use App\Models\Theme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GeminiController extends Controller
{
    public function generateImage(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Allow Time For The Gemini Call
        |--------------------------------------------------------------------------
        |
        | Image generation regularly takes longer than PHP's default
        | max_execution_time (30s), which was killing the request mid-call
        | ("Maximum execution time of 30 seconds exceeded" in Guzzle). Give
        | the script enough headroom to cover the 120s HTTP timeout below.
        */

        set_time_limit(180);


        /*
        |--------------------------------------------------------------------------
        | Validate Request
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'image' => 'required|string',
            'theme_id' => 'required|exists:photoshoot_themes,id',
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
        | Active Occasion
        |--------------------------------------------------------------------------
        |
        | The live database stores events as "occasions" (there is always a
        | default "Walk-In Shop" row). Photo sessions are tied to one.
        */

        $occasion = DB::table('occasions')
            ->where('status', 'active')
            ->orderByDesc('id')
            ->first();

        if (!$occasion) {

            return response()->json([
                'success' => false,
                'message' => 'No active occasion is configured for the photobooth.'
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

        $prompt = trim(
            ($theme->prompt_prefix ?? '') . ' ' . ($theme->prompt_suffix ?? '')
        );

        if ($prompt === '') {

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
        | Gemini Model
        |--------------------------------------------------------------------------
        */

        $model = config('services.gemini.model', '<gemini-3 class="1"></gemini-3>-pro-image-preview');


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
                'https://generativelanguage.googleapis.com/v1beta/models/'
                . $model
                . ':generateContent?key='
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

                        'imageConfig' => [

                            'imageSize' =>
                                '4K',

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
            'session_code' => 'PS-' . now()->format('ymdHis') . '-' . strtoupper(Str::random(4)),
            'raw_photo_path' => 'photobooth/' . $fileName,
            'consent_given' => true,
            'occasion_id' => $occasion->id,
            'status' => 'completed',
        ]);

        $generatedRecord = GeneratedImage::create([
            'photo_session_id' => $photoSession->id,
            'theme_id' => $theme->id,
            'model_id' => 1,
            'final_prompt_used' => $prompt,
            'generated_photo_path' => 'photobooth/' . $generatedFileName,
            'generation_status' => 'success',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Return Result
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'success' => true,

            'theme' =>
                $theme->theme_name,

            'generated_image_id' =>
                $generatedRecord->id,

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