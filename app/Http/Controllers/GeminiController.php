<?php

namespace App\Http\Controllers;

use App\Models\BoothSetting;
use App\Models\GeneratedImage;
use App\Models\PhotoFrame;
use App\Models\PhotoSession;
use App\Models\Theme;
use App\Services\GoogleDriveService;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Sleep;
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

        if (! $occasion) {

            return response()->json([
                'success' => false,
                'message' => 'No active occasion is configured for the photobooth.',
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
                'message' => 'Invalid image data.',
            ], 422);
        }

        /*
        |--------------------------------------------------------------------------
        | Save Original Image
        |--------------------------------------------------------------------------
        */

        $fileName =
            'original_'.
            time().
            '_'.
            uniqid().
            '.jpg';

        Storage::disk('public')->put(
            'photobooth/'.$fileName,
            $imageBinary
        );

        /*
        |--------------------------------------------------------------------------
        | Theme Prompt
        |--------------------------------------------------------------------------
        */

        $prompt = trim(
            ($theme->prompt_prefix ?? '').
            ' '.
            ($theme->prompt_suffix ?? '')
        );

        if ($prompt === '') {

            $this->recordFailedGeneration($theme, $occasion, 'photobooth/'.$fileName, $prompt, 'failed_other', 'The theme has no prompt configured.');

            return response()->json([
                'success' => false,
                'message' => 'This theme has no prompt configured.',
            ], 422);
        }

        /*
        |--------------------------------------------------------------------------
        | Generate AI Image (Gemini or FLUX.2, see AI_PROVIDER)
        |--------------------------------------------------------------------------
        */

        $generated = config('services.ai.provider') === 'flux'
            ? $this->generateWithFlux($theme, $occasion, 'photobooth/'.$fileName, $prompt, $imageData)
            : $this->generateWithGemini($theme, $occasion, 'photobooth/'.$fileName, $prompt, $imageData);

        if ($generated instanceof JsonResponse) {
            return $generated;
        }

        $generatedImage = $generated;

        /*
        |--------------------------------------------------------------------------
        | Save Generated AI Image
        |--------------------------------------------------------------------------
        */

        $generatedBinary = base64_decode(
            $generatedImage
        );

        if ($generatedBinary === false) {

            $this->recordFailedGeneration($theme, $occasion, 'photobooth/'.$fileName, $prompt, 'failed_other', 'The image returned by the AI service could not be decoded.');

            return response()->json([
                'success' => false,
                'message' => 'Unable to decode the AI generated image.',
            ], 500);
        }

        $generatedFileName =
            'generated_'.
            time().
            '_'.
            uniqid().
            '.png';

        $generatedRelativePath =
            'photobooth/'.
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

        /*
         * Use the frame the guest picked on the frame page, when the
         * admin site lets guests pick. Otherwise (or if the pick has
         * since been deactivated) follow the admin site's automatic
         * order: the theme's own frame, then the default frame, then
         * the latest selectable frame.
         */
        $chosenFrame = BoothSetting::guestsCanPickFrame()
            ? PhotoFrame::selectable()->find($request->integer('frame_id'))
            : null;

        $activeFrame = $chosenFrame
            ?? PhotoFrame::selectable()->find($theme->photo_frame_id)
            ?? PhotoFrame::selectable()->where('is_default', true)->first()
            ?? PhotoFrame::selectable()->latest('id')->first();

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
                'frame_'.
                time().
                '_'.
                uniqid().
                '.png';

            $temporaryFramePath =
                storage_path(
                    'app/temp/'.
                    $temporaryFrameName
                );

            try {

                /*
                |--------------------------------------------------------------------------
                | Use The Local Frame Copy, Else Download It From Google Drive
                |--------------------------------------------------------------------------
                */

                copy(
                    Storage::disk('public')->path(
                        $this->localFramePath($activeFrame, $googleDrive)
                    ),
                    $this->ensureDirectory($temporaryFramePath)
                );

                /*
                |--------------------------------------------------------------------------
                | Make Sure Files Exist
                |--------------------------------------------------------------------------
                */

                if (
                    ! file_exists($generatedFullPath) ||
                    ! file_exists($temporaryFramePath)
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
                    ! $generatedImageResource ||
                    ! $frameImageResource
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
                    'final_'.
                    time().
                    '_'.
                    uniqid().
                    '.png';

                $finalRelativePath =
                    'photobooth/'.
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
                        'frame_id' => $activeFrame->id,

                        'google_drive_file_id' => $activeFrame->google_drive_file_id,

                        'error' => $e->getMessage(),
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
            'photobooth/'.
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
            'RV-'.
            now()->format('Ymd').
            '-'.
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

            if (! file_exists($finalFullPath)) {

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
                    $imageUid.'.png'
                );

            $googleDriveFileId =
                $driveResult['id']
                ?? null;

            $googleDriveUrl =
                $driveResult['url']
                ?? null;

            // Make ONLY this generated photo publicly viewable
            if ($googleDriveFileId) {
                try {

                    $googleDrive->makeFilePublic(
                        $googleDriveFileId
                    );

                    $googleDriveStatus = 'public';

                } catch (\Throwable $e) {

                    // The image was uploaded, but public sharing failed.
                    $googleDriveStatus = 'uploaded';

                    Log::warning(
                        'RUPAVUE Google Drive public sharing failed.',
                        [
                            'image_uid' => $imageUid,
                            'google_drive_file_id' => $googleDriveFileId,
                            'error' => $e->getMessage(),
                        ]
                    );
                }

            } else {

                $googleDriveStatus = 'uploaded';
            }

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
                    'image_uid' => $imageUid,

                    'error' => $e->getMessage(),
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

                'session_code' => 'PS-'.
                    now()->format('ymdHis').
                    '-'.
                    strtoupper(
                        Str::random(4)
                    ),

                'raw_photo_path' => 'photobooth/'.
                    $fileName,

                'consent_given' => true,

                'occasion_id' => $occasion->id,

                'status' => 'completed',
            ]);

        /*
        |--------------------------------------------------------------------------
        | Record Generated Image
        |--------------------------------------------------------------------------
        */

        $generatedRecord =
            GeneratedImage::create([

                'photo_session_id' => $photoSession->id,

                'theme_id' => $theme->id,

                'model_id' => 1,

                'public_token' => bin2hex(random_bytes(32)),

                'final_prompt_used' => $prompt,

                'generated_photo_path' => 'photobooth/'.
                    $finalFileName,

                'applied_frame_path' => $appliedFramePath,

                /*
                 * The guest's own pick, read by the admin site's
                 * branding trigger; null lets it choose automatically.
                 */
                'chosen_frame_id' => $chosenFrame?->id,

                'generation_status' => 'success',

                /*
                |--------------------------------------------------------------------------
                | RUPAVUE Image ID
                |--------------------------------------------------------------------------
                */

                'image_uid' => $imageUid,

                /*
                |--------------------------------------------------------------------------
                | Google Drive Information
                |--------------------------------------------------------------------------
                */

                'google_drive_file_id' => $googleDriveFileId,

                'google_drive_url' => $googleDriveUrl,

                'google_drive_status' => $googleDriveStatus,
            ]);

        /*
        |--------------------------------------------------------------------------
        | Return Result
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'success' => true,

            'theme' => $theme->theme_name,

            /*
            |--------------------------------------------------------------------------
            | Database ID
            |--------------------------------------------------------------------------
            */

            'generated_image_id' => $generatedRecord->id,

            /*
            |--------------------------------------------------------------------------
            | RUPAVUE Image ID
            |--------------------------------------------------------------------------
            */

            'image_uid' => $generatedRecord->image_uid,

            /*
            |--------------------------------------------------------------------------
            | Original Image
            |--------------------------------------------------------------------------
            */

            'original_image' => Storage::url(
                'photobooth/'.
                $fileName
            ),

            /*
            |--------------------------------------------------------------------------
            | FINAL Image
            |--------------------------------------------------------------------------
            */

            'generated_image' => Storage::url(
                'photobooth/'.
                $finalFileName
            ),

            /*
            |--------------------------------------------------------------------------
            | AI Image Without Frame
            |--------------------------------------------------------------------------
            |
            | Shown full screen on the result page before the
            | framed photo settles into place.
            |
            */

            'ai_image' => Storage::url(
                $generatedRelativePath
            ),

            /*
            |--------------------------------------------------------------------------
            | Frame
            |--------------------------------------------------------------------------
            */

            'frame_applied' => $appliedFramePath !== null,

            'frame_id' => $appliedFramePath !== null ? $activeFrame->id : null,

            /*
            |--------------------------------------------------------------------------
            | Google Drive
            |--------------------------------------------------------------------------
            */

            'google_drive_status' => $generatedRecord
                ->google_drive_status,

            'google_drive_file_id' => $generatedRecord
                ->google_drive_file_id,

            'google_drive_url' => $generatedRecord
                ->google_drive_url,

            /*
            |--------------------------------------------------------------------------
            | Public Photo Page (Google Drive-backed download)
            |--------------------------------------------------------------------------
            */

            'public_token' => $generatedRecord
                ->public_token,

            'public_photo_url' => $generatedRecord->publicPhotoUrl(),

            'qr_code_url' => route('public.photo.qr', $generatedRecord->public_token),
        ]);
    }

    /**
     * Restyle the guest's photo with Gemini.
     *
     * Returns the generated image as base64, or the error response
     * to send back to the booth.
     */
    private function generateWithGemini(Theme $theme, object $occasion, string $rawPhotoPath, string $prompt, string $imageData): string|JsonResponse
    {
        /*
        |--------------------------------------------------------------------------
        | Gemini API Key
        |--------------------------------------------------------------------------
        */

        $apiKey = env('GEMINI_API_KEY');

        if (! $apiKey) {

            $this->recordFailedGeneration($theme, $occasion, $rawPhotoPath, $prompt, 'failed_other', 'The Gemini API key is not configured on the photobooth.');

            return response()->json([
                'success' => false,
                'message' => 'Gemini API key is not configured.',
            ], 500);
        }

        /*
        |--------------------------------------------------------------------------
        | Gemini Model
        |--------------------------------------------------------------------------
        */

        $model = config(
            'services.gemini.model',
            'gemini-3.1-flash-image'
        );

        /*
        |--------------------------------------------------------------------------
        | Gemini Request
        |--------------------------------------------------------------------------
        */

        try {
            $response = $this->requestGeminiImage($model, $apiKey, $prompt, $imageData);
        } catch (ConnectionException $e) {

            Log::error('RUPAVUE Gemini image generation timed out.', ['model' => $model, 'error' => $e->getMessage()]);

            $this->recordFailedGeneration($theme, $occasion, $rawPhotoPath, $prompt, 'failed_timeout', 'Gemini did not respond in time: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'The AI service took too long to respond. Please try again.',
            ], 504);
        }

        /*
        |--------------------------------------------------------------------------
        | Check Gemini Response
        |--------------------------------------------------------------------------
        */

        if (! $response->successful()) {

            Log::error(
                'RUPAVUE Gemini image generation failed.',
                [
                    'status' => $response->status(),
                    'model' => $model,
                    'error' => $response->json(),
                ]
            );

            $this->recordFailedGeneration(
                $theme,
                $occasion,
                $rawPhotoPath,
                $prompt,
                in_array($response->status(), [408, 504], true) ? 'failed_timeout' : 'failed_other',
                'Gemini returned HTTP '.$response->status().': '.(data_get($response->json(), 'error.message') ?: 'no error message')
            );

            $userMessage = match ($response->status()) {
                429 => 'The AI service is out of quota or too busy right now. Please try again shortly or ask a staff member for help.',
                400, 401, 403 => 'The AI service rejected the request. Please ask a staff member for help.',
                default => 'Gemini image generation failed. Please try again.',
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

        if (! $generatedImage) {

            [$failureStatus, $failureReason] = $this->describeMissingImage($responseData ?? []);

            $this->recordFailedGeneration($theme, $occasion, $rawPhotoPath, $prompt, $failureStatus, $failureReason);

            return response()->json([
                'success' => false,
                'message' => 'Gemini did not return an image.',
                'response' => $responseData,
            ], 500);
        }

        return $generatedImage;
    }

    /**
     * Restyle the guest's photo with Black Forest Labs' FLUX.2.
     *
     * FLUX.2 runs as a job: submit it, poll its polling_url until it
     * is ready, then download the image from the signed result URL
     * (valid for 10 minutes). The photo is sent as base64 because
     * BFL cannot reach the booth to fetch it by URL.
     *
     * Returns the generated image as base64, or the error response
     * to send back to the booth.
     */
    private function generateWithFlux(Theme $theme, object $occasion, string $rawPhotoPath, string $prompt, string $imageData): string|JsonResponse
    {
        $apiKey = config('services.bfl.api_key');

        if (! $apiKey) {

            $this->recordFailedGeneration($theme, $occasion, $rawPhotoPath, $prompt, 'failed_other', 'The Black Forest Labs API key is not configured on the photobooth.');

            return response()->json([
                'success' => false,
                'message' => 'FLUX API key is not configured.',
            ], 500);
        }

        $model = config('services.bfl.model', 'flux-2-pro');

        $bfl = fn (int $timeout) => Http::timeout($timeout)
            ->withHeaders(['x-key' => $apiKey])
            ->acceptJson();

        try {

            $submission = $bfl(30)->post('https://api.bfl.ai/v1/'.$model, [
                'prompt' => $prompt,
                'input_image' => $imageData,
                'width' => 1728,
                'height' => 1152,
                'output_format' => 'png',
            ]);

            if (! $submission->successful()) {
                return $this->fluxHttpFailure($theme, $occasion, $rawPhotoPath, $prompt, $model, $submission);
            }

            /*
             * Poll about once a second for up to two minutes.
             */
            $result = null;

            for ($attempt = 0; $attempt < 120; $attempt++) {

                Sleep::for(1)->second();

                $poll = $bfl(15)->get($submission->json('polling_url'));

                if (! $poll->successful()) {
                    return $this->fluxHttpFailure($theme, $occasion, $rawPhotoPath, $prompt, $model, $poll);
                }

                $status = (string) $poll->json('status');

                if ($status === 'Ready') {
                    $result = $poll;

                    break;
                }

                if (in_array($status, ['Request Moderated', 'Content Moderated'], true)) {
                    return $this->fluxFailure($theme, $occasion, $rawPhotoPath, $prompt, 'failed_nsfw', 'FLUX did not return an image ('.$status.').', 'This photo could not be processed. Please try another photo.', 500);
                }

                if (in_array($status, ['Error', 'Failed', 'Task not found'], true)) {
                    return $this->fluxFailure($theme, $occasion, $rawPhotoPath, $prompt, 'failed_other', 'FLUX did not return an image ('.$status.').', 'FLUX image generation failed. Please try again.', 500);
                }
            }

            if (! $result) {
                return $this->fluxFailure($theme, $occasion, $rawPhotoPath, $prompt, 'failed_timeout', 'FLUX did not finish the image within two minutes.', 'The AI service took too long to respond. Please try again.', 504);
            }

            $download = Http::timeout(30)->get($result->json('result.sample'));

            if (! $download->successful() || $download->body() === '') {
                return $this->fluxFailure($theme, $occasion, $rawPhotoPath, $prompt, 'failed_other', 'The FLUX image could not be downloaded (HTTP '.$download->status().').', 'FLUX image generation failed. Please try again.', 500);
            }

        } catch (ConnectionException $e) {

            Log::error('RUPAVUE FLUX image generation timed out.', ['model' => $model, 'error' => $e->getMessage()]);

            return $this->fluxFailure($theme, $occasion, $rawPhotoPath, $prompt, 'failed_timeout', 'FLUX did not respond in time: '.$e->getMessage(), 'The AI service took too long to respond. Please try again.', 504);
        }

        return base64_encode($download->body());
    }

    /**
     * Record and report an HTTP error from the BFL API.
     */
    private function fluxHttpFailure(Theme $theme, object $occasion, string $rawPhotoPath, string $prompt, string $model, Response $response): JsonResponse
    {
        $detail = $response->json('detail') ?? 'no error message';

        Log::error('RUPAVUE FLUX image generation failed.', [
            'status' => $response->status(),
            'model' => $model,
            'error' => $response->json(),
        ]);

        $userMessage = match ($response->status()) {
            402 => 'The AI service is out of credits. Please ask a staff member for help.',
            429 => 'The AI service is too busy right now. Please try again shortly or ask a staff member for help.',
            400, 401, 403, 422 => 'The AI service rejected the request. Please ask a staff member for help.',
            default => 'FLUX image generation failed. Please try again.',
        };

        return $this->fluxFailure(
            $theme,
            $occasion,
            $rawPhotoPath,
            $prompt,
            in_array($response->status(), [408, 504], true) ? 'failed_timeout' : 'failed_other',
            'FLUX returned HTTP '.$response->status().': '.(is_string($detail) ? $detail : json_encode($detail)),
            $userMessage,
            500
        );
    }

    /**
     * Save a failed FLUX attempt and build the response for the booth.
     */
    private function fluxFailure(Theme $theme, object $occasion, string $rawPhotoPath, string $prompt, string $status, string $reason, string $userMessage, int $httpStatus): JsonResponse
    {
        $this->recordFailedGeneration($theme, $occasion, $rawPhotoPath, $prompt, $status, $reason);

        return response()->json([
            'success' => false,
            'message' => $userMessage,
        ], $httpStatus);
    }

    /**
     * Ask Gemini to restyle the guest's photo with the theme prompt.
     */
    private function requestGeminiImage(string $model, string $apiKey, string $prompt, string $imageData): Response
    {
        return Http::timeout(120)
            ->withHeaders([
                'Content-Type' => 'application/json',
            ])
            ->post(
                'https://generativelanguage.googleapis.com/v1beta/models/'.$model.':generateContent?key='.$apiKey,
                [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $prompt],
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
                        'responseModalities' => ['TEXT', 'IMAGE'],
                        'imageConfig' => [
                            'imageSize' => '2k',
                            'aspectRatio' => '3:2',
                        ],
                    ],
                ]
            );
    }

    /**
     * Failure status and reason for a Gemini reply without an image,
     * treating safety blocks as NSFW.
     *
     * @param  array<string, mixed>  $responseData
     * @return array{0: string, 1: string}
     */
    private function describeMissingImage(array $responseData): array
    {
        $blockReason = data_get($responseData, 'promptFeedback.blockReason');
        $finishReason = data_get($responseData, 'candidates.0.finishReason');

        $modelText = collect(data_get($responseData, 'candidates.0.content.parts', []))
            ->pluck('text')
            ->filter()
            ->implode(' ');

        $isSafetyBlock = $blockReason
            || in_array($finishReason, ['SAFETY', 'IMAGE_SAFETY', 'PROHIBITED_CONTENT', 'BLOCKLIST', 'SPII'], true);

        $reason = 'Gemini did not return an image';

        if ($blockReason || $finishReason) {
            $reason .= ' ('.($blockReason ?: $finishReason).')';
        }

        if ($modelText !== '') {
            $reason .= ': '.$modelText;
        }

        return [$isSafetyBlock ? 'failed_nsfw' : 'failed_other', $reason.'.'];
    }

    /**
     * Save a failed attempt so the RupaVue admin site can show the
     * session and why the AI image could not be generated.
     */
    private function recordFailedGeneration(Theme $theme, object $occasion, string $rawPhotoPath, string $prompt, string $status, string $reason): void
    {
        try {
            $photoSession = PhotoSession::create([
                'session_code' => 'PS-'.now()->format('ymdHis').'-'.strtoupper(Str::random(4)),
                'raw_photo_path' => $rawPhotoPath,
                'consent_given' => true,
                'occasion_id' => $occasion->id,
                'status' => 'abandoned',
            ]);

            GeneratedImage::create([
                'photo_session_id' => $photoSession->id,
                'theme_id' => $theme->id,
                'model_id' => 1,
                'final_prompt_used' => $prompt,
                'generation_status' => $status,
                'failure_reason' => Str::limit($reason, 500, ''),
            ]);
        } catch (\Throwable $e) {
            Log::error('RUPAVUE failed generation could not be recorded.', [
                'status' => $status,
                'reason' => $reason,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Path (on the public disk) of a local copy of the frame.
     *
     * When the copy is missing, the frame is fetched through the
     * Google Drive API, or its public download link when Drive
     * is not connected, and kept locally for the next photo.
     */
    private function localFramePath(PhotoFrame $frame, GoogleDriveService $googleDrive): string
    {
        $disk = Storage::disk('public');

        if ($frame->frame_path && $disk->exists($frame->frame_path)) {
            return $frame->frame_path;
        }

        $framePath = $frame->frame_path ?: 'frames/drive_'.preg_replace('/[^A-Za-z0-9_-]/', '', $frame->google_drive_file_id).'.png';

        try {
            $googleDrive->downloadFile(
                $frame->google_drive_file_id,
                $this->ensureDirectory($disk->path($framePath))
            );
        } catch (\Throwable $e) {
            $response = Http::timeout(30)->get('https://drive.google.com/uc', [
                'export' => 'download',
                'id' => $frame->google_drive_file_id,
            ]);

            if (! $response->successful() || ! str_starts_with((string) $response->header('Content-Type'), 'image/')) {
                throw new \Exception(
                    'Unable to download the photo frame from Google Drive: '.$e->getMessage()
                );
            }

            $disk->put($framePath, $response->body());
        }

        if ($frame->frame_path !== $framePath) {
            $frame->update(['frame_path' => $framePath]);
        }

        return $framePath;
    }

    private function ensureDirectory(string $filePath): string
    {
        if (! is_dir(dirname($filePath))) {
            mkdir(dirname($filePath), 0755, true);
        }

        return $filePath;
    }
}
