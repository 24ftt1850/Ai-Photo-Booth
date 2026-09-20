<?php

namespace App\Http\Controllers;

use App\Models\GeneratedImage;
use App\Models\PhotoFrame;
use App\Models\PhotoSession;
use App\Models\Theme;
use App\Services\GoogleDriveService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


class GeminiController extends Controller
{
    public function generateImage(
        Request $request,
        GoogleDriveService $googleDrive
    ) {
        /*
        |--------------------------------------------------------------------------
        | Allow Time For The Gemini Call
        |--------------------------------------------------------------------------
        */

        set_time_limit(180);
        ini_set('memory_limit', '512M');


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

        $theme = Theme::findOrFail(
            $request->input('theme_id')
        );


        /*
        |--------------------------------------------------------------------------
        | Active Occasion
        |--------------------------------------------------------------------------
        */

        $occasion = DB::table('occasions')
            ->where('status', 'active')
            ->orderByDesc('id')
            ->first();

        if (!$occasion) {

            return response()->json([
                'success' => false,
                'message' =>
                    'No active occasion is configured for the photobooth.'
            ], 500);
        }


        /*
        |--------------------------------------------------------------------------
        | Remove Base64 Header
        |--------------------------------------------------------------------------
        */

        if (str_contains($imageData, ',')) {

            $imageData = explode(
                ',',
                $imageData,
                2
            )[1];
        }


        /*
        |--------------------------------------------------------------------------
        | Decode Image
        |--------------------------------------------------------------------------
        */

        $imageBinary = base64_decode(
            $imageData
        );

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
            ($theme->prompt_prefix ?? '') .
            ' ' .
            ($theme->prompt_suffix ?? '')
        );

        if ($prompt === '') {

            return response()->json([
                'success' => false,
                'message' =>
                    'This theme has no prompt configured.'
            ], 422);
        }


        /*
        |--------------------------------------------------------------------------
        | Gemini API Key
        |--------------------------------------------------------------------------
        */

        $apiKey = env('GEMINI_API_KEY');

        if (!$apiKey) {

            return response()->json([
                'success' => false,
                'message' =>
                    'Gemini API key is not configured.'
            ], 500);
        }


        /*
        |--------------------------------------------------------------------------
        | Gemini Model
        |--------------------------------------------------------------------------
        */

        $model = config(
            'services.gemini.model',
            'gemini-3-pro-image-preview'
        );


        /*
        |--------------------------------------------------------------------------
        | Gemini Request
        |--------------------------------------------------------------------------
        */

        $response = Http::timeout(120)
            ->withHeaders([
                'Content-Type' => 'application/json',
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
                                        'mime_type' => 'image/jpeg',
                                        'data' => $imageData,
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
                            'imageSize' => '2K',
                            'aspectRatio' => '3:2',
                        ],

                    ],
                ]
            );


        /*
        |--------------------------------------------------------------------------
        | Check Gemini Response
        |--------------------------------------------------------------------------
        */

        if (!$response->successful()) {

            Log::error(
                'RUPAVUE Gemini image generation failed.',
                [
                    'status' => $response->status(),
                    'model' => $model,
                    'error' => $response->json(),
                ]
            );

            $userMessage = match ($response->status()) {
                429 =>
                    'The AI service is out of quota or too busy right now. Please try again shortly or ask a staff member for help.',
                400, 401, 403 =>
                    'The AI service rejected the request. Please ask a staff member for help.',
                default =>
                    'Gemini image generation failed. Please try again.',
            };

            return response()->json([
                'success' => false,
                'message' => $userMessage,
                'error' => $response->json(),
            ], 500);
        }


        /*
        |--------------------------------------------------------------------------
        | Find Generated Image
        |--------------------------------------------------------------------------
        */

        $responseData = $response->json();

        $generatedImage = null;

        $parts = data_get(
            $responseData,
            'candidates.0.content.parts',
            []
        );

        foreach ($parts as $part) {

            if (
                isset($part['inlineData']['data'])
            ) {

                $generatedImage =
                    $part['inlineData']['data'];

                break;
            }


            if (
                isset($part['inline_data']['data'])
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
                'response' => $responseData,
            ], 500);
        }


        /*
        |--------------------------------------------------------------------------
        | Save Generated AI Image
        |--------------------------------------------------------------------------
        */

        $generatedBinary = base64_decode(
            $generatedImage
        );

        if ($generatedBinary === false) {

            return response()->json([
                'success' => false,
                'message' =>
                    'Unable to decode Gemini generated image.'
            ], 500);
        }


        $generatedFileName =
            'generated_' .
            time() .
            '_' .
            uniqid() .
            '.png';


        $generatedRelativePath =
            'photobooth/' .
            $generatedFileName;


        Storage::disk('public')->put(
            $generatedRelativePath,
            $generatedBinary
        );


        /*
        |--------------------------------------------------------------------------
        | Apply Active Photo Frame
        |--------------------------------------------------------------------------
        */

        $activeFrame = PhotoFrame::where(
            'is_active',
            true
        )
            ->latest('id')
            ->first();


        /*
        |--------------------------------------------------------------------------
        | Default
        |--------------------------------------------------------------------------
        */

        $finalFileName = $generatedFileName;

        $appliedFramePath = null;


        /*
        |--------------------------------------------------------------------------
        | If An Active Frame Exists
        |--------------------------------------------------------------------------
        */

        if (
            $activeFrame &&
            $activeFrame->google_drive_file_id
        ) {

            $generatedFullPath =
                Storage::disk('public')
                    ->path($generatedRelativePath);

            $temporaryFrameName =
                'frame_' .
                time() .
                '_' .
                uniqid() .
                '.png';

            $temporaryFramePath =
                storage_path(
                    'app/temp/' .
                    $temporaryFrameName
                );

            try {

                /*
                |--------------------------------------------------------------------------
                | Download Frame From Google Drive
                |--------------------------------------------------------------------------
                */

                $googleDrive->downloadFile(
                    $activeFrame->google_drive_file_id,
                    $temporaryFramePath
                );


                /*
                |--------------------------------------------------------------------------
                | Make Sure Files Exist
                |--------------------------------------------------------------------------
                */

                if (
                    !file_exists($generatedFullPath) ||
                    !file_exists($temporaryFramePath)
                ) {
                    throw new \Exception(
                        'Generated image or Google Drive frame file does not exist.'
                    );
                }


                /*
                |--------------------------------------------------------------------------
                | Load Generated AI Image
                |--------------------------------------------------------------------------
                */

                $generatedImageResource =
                    imagecreatefromstring(
                        file_get_contents(
                            $generatedFullPath
                        )
                    );


                /*
                |--------------------------------------------------------------------------
                | Load Google Drive Frame
                |--------------------------------------------------------------------------
                */

                $frameImageResource =
                    imagecreatefromstring(
                        file_get_contents(
                            $temporaryFramePath
                        )
                    );


                if (
                    !$generatedImageResource ||
                    !$frameImageResource
                ) {
                    throw new \Exception(
                        'Unable to load generated image or photo frame.'
                    );
                }


                /*
                |--------------------------------------------------------------------------
                | Frame Dimensions
                |--------------------------------------------------------------------------
                */

                $finalWidth =
                    imagesx(
                        $frameImageResource
                    );

                $finalHeight =
                    imagesy(
                        $frameImageResource
                    );


                /*
                |--------------------------------------------------------------------------
                | Create Final Canvas
                |--------------------------------------------------------------------------
                */

                $resizedImage =
                    imagecreatetruecolor(
                        $finalWidth,
                        $finalHeight
                    );


                /*
                |--------------------------------------------------------------------------
                | Preserve Transparency
                |--------------------------------------------------------------------------
                */

                imagealphablending(
                    $resizedImage,
                    false
                );

                imagesavealpha(
                    $resizedImage,
                    true
                );

                $transparent =
                    imagecolorallocatealpha(
                        $resizedImage,
                        0,
                        0,
                        0,
                        127
                    );

                imagefill(
                    $resizedImage,
                    0,
                    0,
                    $transparent
                );


                /*
                |--------------------------------------------------------------------------
                | Resize AI Image To Frame Size
                |--------------------------------------------------------------------------
                */

                imagecopyresampled(
                    $resizedImage,
                    $generatedImageResource,
                    0,
                    0,
                    0,
                    0,
                    $finalWidth,
                    $finalHeight,
                    imagesx(
                        $generatedImageResource
                    ),
                    imagesy(
                        $generatedImageResource
                    )
                );


                /*
                |--------------------------------------------------------------------------
                | Put Frame Above AI Image
                |--------------------------------------------------------------------------
                */

                imagealphablending(
                    $resizedImage,
                    true
                );

                imagesavealpha(
                    $resizedImage,
                    true
                );

                imagecopy(
                    $resizedImage,
                    $frameImageResource,
                    0,
                    0,
                    0,
                    0,
                    $finalWidth,
                    $finalHeight
                );


                /*
                |--------------------------------------------------------------------------
                | Final File Name
                |--------------------------------------------------------------------------
                */

                $finalFileName =
                    'final_' .
                    time() .
                    '_' .
                    uniqid() .
                    '.png';

                $finalRelativePath =
                    'photobooth/' .
                    $finalFileName;

                $finalFullPath =
                    Storage::disk('public')
                        ->path(
                            $finalRelativePath
                        );


                /*
                |--------------------------------------------------------------------------
                | Save Final Framed Image
                |--------------------------------------------------------------------------
                */

                imagepng(
                    $resizedImage,
                    $finalFullPath,
                    6
                );


                /*
                |--------------------------------------------------------------------------
                | Clean Up GD Resources
                |--------------------------------------------------------------------------
                */

                imagedestroy(
                    $generatedImageResource
                );

                imagedestroy(
                    $frameImageResource
                );

                imagedestroy(
                    $resizedImage
                );


                /*
                |--------------------------------------------------------------------------
                | Save Applied Frame
                |--------------------------------------------------------------------------
                */

                $appliedFramePath =
                    $activeFrame->frame_path;


            } catch (\Throwable $e) {

                Log::error(
                    'RUPAVUE Google Drive photo frame failed.',
                    [
                        'frame_id' =>
                            $activeFrame->id,

                        'google_drive_file_id' =>
                            $activeFrame->google_drive_file_id,

                        'error' =>
                            $e->getMessage(),
                    ]
                );

                /*
                |--------------------------------------------------------------------------
                | If Frame Fails, Keep AI Image
                |--------------------------------------------------------------------------
                */

                $finalFileName =
                    $generatedFileName;

            }


            /*
            |--------------------------------------------------------------------------
            | Delete Temporary Frame
            |--------------------------------------------------------------------------
            */

            if (
                file_exists($temporaryFramePath)
            ) {
                unlink(
                    $temporaryFramePath
                );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Final Image Full Path
        |--------------------------------------------------------------------------
        |
        | If no frame exists, the Gemini-generated image itself
        | becomes the final image.
        |
        */

        $finalRelativePath =
            'photobooth/' .
            $finalFileName;

        $finalFullPath =
            Storage::disk('public')
                ->path($finalRelativePath);


        /*
        |--------------------------------------------------------------------------
        | Generate RUPAVUE Image ID
        |--------------------------------------------------------------------------
        */

        $imageUid =
            'RV-' .
            now()->format('Ymd') .
            '-' .
            strtoupper(
                Str::random(6)
            );


        /*
        |--------------------------------------------------------------------------
        | Upload FINAL Image To Google Drive
        |--------------------------------------------------------------------------
        */

        $googleDriveFileId = null;

        $googleDriveUrl = null;

        $googleDriveStatus = 'pending';


        try {

            /*
            |--------------------------------------------------------------------------
            | Make sure final image exists
            |--------------------------------------------------------------------------
            */

            if (!file_exists($finalFullPath)) {

                throw new \Exception(
                    'Final image file does not exist.'
                );
            }


            /*
            |--------------------------------------------------------------------------
            | Upload final framed PNG
            |--------------------------------------------------------------------------
            */

            $driveResult =
                $googleDrive->uploadImage(
                    $finalFullPath,
                    $imageUid . '.png'
                );


            $googleDriveFileId =
                $driveResult['id']
                ?? null;

            // Make ONLY this generated photo publicly viewable
            if ($googleDriveFileId) {
                $googleDrive->makeFilePublic($googleDriveFileId);
            }

            $googleDriveUrl =
                $driveResult['url']
                ?? null;

            $googleDriveStatus =
                'uploaded';

        } catch (\Throwable $e) {

            /*
            |--------------------------------------------------------------------------
            | Do not fail image generation if Drive fails
            |--------------------------------------------------------------------------
            */

            $googleDriveStatus =
                'failed';

            Log::error(
                'RUPAVUE Google Drive upload failed.',
                [
                    'image_uid' =>
                        $imageUid,

                    'error' =>
                        $e->getMessage(),
                ]
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Record Photo Session
        |--------------------------------------------------------------------------
        */

        $photoSession =
            PhotoSession::create([

                'session_code' =>
                    'PS-' .
                    now()->format('ymdHis') .
                    '-' .
                    strtoupper(
                        Str::random(4)
                    ),

                'raw_photo_path' =>
                    'photobooth/' .
                    $fileName,

                'consent_given' =>
                    true,

                'occasion_id' =>
                    $occasion->id,

                'status' =>
                    'completed',
            ]);


        /*
        |--------------------------------------------------------------------------
        | Record Generated Image
        |--------------------------------------------------------------------------
        */

        $generatedRecord =
            GeneratedImage::create([

                'photo_session_id' =>
                    $photoSession->id,

                'theme_id' =>
                    $theme->id,

                'model_id' =>
                    1,

                'public_token' => bin2hex(random_bytes(32)),

                'final_prompt_used' =>
                    $prompt,

                'generated_photo_path' =>
                    'photobooth/' .
                    $finalFileName,

                'applied_frame_path' =>
                    $appliedFramePath,

                'generation_status' =>
                    'success',

                /*
                |--------------------------------------------------------------------------
                | RUPAVUE Image ID
                |--------------------------------------------------------------------------
                */

                'image_uid' =>
                    $imageUid,

                /*
                |--------------------------------------------------------------------------
                | Google Drive Information
                |--------------------------------------------------------------------------
                */

                'google_drive_file_id' =>
                    $googleDriveFileId,

                'google_drive_url' =>
                    $googleDriveUrl,

                'google_drive_status' =>
                    $googleDriveStatus,
            ]);


        /*
        |--------------------------------------------------------------------------
        | Return Result
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'success' =>
                true,

            'theme' =>
                $theme->theme_name,

            /*
            |--------------------------------------------------------------------------
            | Database ID
            |--------------------------------------------------------------------------
            */

            'generated_image_id' =>
                $generatedRecord->id,

            /*
            |--------------------------------------------------------------------------
            | RUPAVUE Image ID
            |--------------------------------------------------------------------------
            */

            'image_uid' =>
                $generatedRecord->image_uid,

            /*
            |--------------------------------------------------------------------------
            | Original Image
            |--------------------------------------------------------------------------
            */

            'original_image' =>
                Storage::url(
                    'photobooth/' .
                    $fileName
                ),

            /*
            |--------------------------------------------------------------------------
            | FINAL Image
            |--------------------------------------------------------------------------
            */

            'generated_image' =>
                Storage::url(
                    'photobooth/' .
                    $finalFileName
                ),

            /*
            |--------------------------------------------------------------------------
            | Frame
            |--------------------------------------------------------------------------
            */

            'frame_applied' =>
                $activeFrame !== null,

            /*
            |--------------------------------------------------------------------------
            | Google Drive
            |--------------------------------------------------------------------------
            */

            'google_drive_status' =>
                $generatedRecord
                    ->google_drive_status,

            'google_drive_file_id' =>
                $generatedRecord
                    ->google_drive_file_id,

            'google_drive_url' =>
                $generatedRecord
                    ->google_drive_url,

            /*
            |--------------------------------------------------------------------------
            | Public Photo Page (Google Drive-backed download)
            |--------------------------------------------------------------------------
            */

            'public_token' =>
                $generatedRecord
                    ->public_token,

            'public_photo_url' =>
                route(
                    'public.photo.show',
                    $generatedRecord->public_token
                ),
        ]);
    }
}