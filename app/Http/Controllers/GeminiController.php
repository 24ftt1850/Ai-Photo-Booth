<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class GeminiController extends Controller
{
    public function generateImage(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Disable PHP execution timeout
        |--------------------------------------------------------------------------
        |
        | Gemini image generation can take a while.
        | We are using streaming, so we do not want PHP to terminate
        | the request while Gemini is still generating.
        |
        */

        set_time_limit(0);


        /*
        |--------------------------------------------------------------------------
        | Get data from browser
        |--------------------------------------------------------------------------
        */

        $photo = $request->input('photo');

        $theme = $request->input('theme');

        $prompt = $request->input('prompt');


        /*
        |--------------------------------------------------------------------------
        | Validate photo
        |--------------------------------------------------------------------------
        */

        if (!$photo) {

            return response()->json([
                'success' => false,
                'error' => 'No photo was provided.'
            ], 400);

        }


        /*
        |--------------------------------------------------------------------------
        | Validate prompt
        |--------------------------------------------------------------------------
        */

        if (!$prompt) {

            return response()->json([
                'success' => false,
                'error' => 'No theme prompt was provided.'
            ], 400);

        }


        /*
        |--------------------------------------------------------------------------
        | Get MIME type and Base64 data
        |--------------------------------------------------------------------------
        */

        $mimeType = 'image/jpeg';


        if (str_contains($photo, ',')) {

            $parts =
                explode(',', $photo, 2);

            $header =
                $parts[0];

            $photo =
                $parts[1];


            if (
                str_contains(
                    $header,
                    'image/png'
                )
            ) {

                $mimeType =
                    'image/png';

            } elseif (
                str_contains(
                    $header,
                    'image/webp'
                )
            ) {

                $mimeType =
                    'image/webp';

            } elseif (
                str_contains(
                    $header,
                    'image/jpeg'
                )
            ) {

                $mimeType =
                    'image/jpeg';

            }

        }


        /*
        |--------------------------------------------------------------------------
        | Get Gemini API key
        |--------------------------------------------------------------------------
        */

        $apiKey =
            config('services.gemini.api_key');


        if (!$apiKey) {

            return response()->json([
                'success' => false,
                'error' => 'Gemini API key is missing.'
            ], 500);

        }


        /*
        |--------------------------------------------------------------------------
        | Build AI prompt
        |--------------------------------------------------------------------------
        */

        $fullPrompt = $prompt . '

IMPORTANT:
Preserve the persons identity and facial features from the provided photo.
Keep the face recognizable and natural.
Preserve the persons general appearance and proportions.

Create a high-quality professional AI portrait.
Make the result photorealistic.
Use cinematic professional lighting.
Make the environment match the selected theme.

Do not change the persons identity.
Do not distort the face.
Do not add extra people.
';


        /*
        |--------------------------------------------------------------------------
        | Gemini payload
        |--------------------------------------------------------------------------
        */

        $payload = [

            'model' =>
                'gemini-3.1-flash-lite-image',

            'input' => [

                [
                    'type' =>
                        'image',

                    'mime_type' =>
                        $mimeType,

                    'data' =>
                        $photo,
                ],

                [
                    'type' =>
                        'text',

                    'text' =>
                        $fullPrompt,
                ],

            ],

            /*
            |--------------------------------------------------------------------------
            | Stream response
            |--------------------------------------------------------------------------
            */

            'stream' =>
                true,

            'response_format' => [

                'type' =>
                    'image',

                'mime_type' =>
                    'image/jpeg',

                'aspect_ratio' =>
                    '1:1',

                'image_size' =>
                    '1K',

            ],

        ];


        /*
        |--------------------------------------------------------------------------
        | Return Server-Sent Events
        |--------------------------------------------------------------------------
        */

        return response()->stream(
            function () use (
                $apiKey,
                $payload,
                $theme
            ) {

                /*
                |--------------------------------------------------------------------------
                | Prevent output buffering
                |--------------------------------------------------------------------------
                */

                while (ob_get_level() > 0) {
                    ob_end_flush();
                }


                /*
                |--------------------------------------------------------------------------
                | Send SSE event helper
                |--------------------------------------------------------------------------
                */

                $sendEvent =
                    function (
                        string $event,
                        array $data
                    ) {

                        echo "event: "
                            . $event
                            . "\n";

                        echo "data: "
                            . json_encode(
                                $data,
                                JSON_UNESCAPED_SLASHES
                            )
                            . "\n\n";

                        if (
                            function_exists(
                                'ob_flush'
                            )
                        ) {

                            @ob_flush();

                        }

                        flush();

                    };


                /*
                |--------------------------------------------------------------------------
                | Tell browser generation started
                |--------------------------------------------------------------------------
                */

                $sendEvent(
                    'status',
                    [
                        'message' =>
                            'Connecting to Gemini...'
                    ]
                );


                /*
                |--------------------------------------------------------------------------
                | Image variables
                |--------------------------------------------------------------------------
                */

                $imageData =
                    null;

                $imageMimeType =
                    'image/jpeg';


                /*
                |--------------------------------------------------------------------------
                | Connect to Gemini
                |--------------------------------------------------------------------------
                */

                try {

                    $response =
                        Http::withHeaders([

                            'Content-Type' =>
                                'application/json',

                            'x-goog-api-key' =>
                                $apiKey,

                        ])

                        /*
                        |--------------------------------------------------------------------------
                        | Important: streaming connection
                        |--------------------------------------------------------------------------
                        */

                        ->withOptions([

                            'stream' =>
                                true,

                            'timeout' =>
                                0,

                            'connect_timeout' =>
                                20,

                        ])

                        ->post(
                            'https://generativelanguage.googleapis.com/v1beta/interactions',
                            $payload
                        );


                } catch (\Throwable $e) {

                    $sendEvent(
                        'error',
                        [

                            'message' =>
                                $e->getMessage(),

                        ]
                    );

                    return;

                }


                /*
                |--------------------------------------------------------------------------
                | Check Gemini HTTP status
                |--------------------------------------------------------------------------
                */

                if ($response->failed()) {

                    $errorBody = $response->body();

                    $sendEvent(
                        'error',
                        [
                            'message' =>
                                'Gemini API returned an error.',

                            'details' =>
                                $errorBody,

                            'http_code' =>
                                $response->status(),
                        ]
                    );

                    return;
}


                /*
                |--------------------------------------------------------------------------
                | Get underlying PSR stream
                |--------------------------------------------------------------------------
                */

                $psrResponse =
                    $response->toPsrResponse();


                $body =
                    $psrResponse->getBody();


                /*
                |--------------------------------------------------------------------------
                | Read SSE stream
                |--------------------------------------------------------------------------
                */

                $buffer = '';


                while (
                    !$body->eof()
                ) {

                    $chunk =
                        $body->read(8192);


                    if (
                        $chunk === ''
                    ) {

                        usleep(10000);

                        continue;

                    }


                    $buffer .=
                        $chunk;


                    /*
                    |--------------------------------------------------------------------------
                    | SSE events are separated by blank lines
                    |--------------------------------------------------------------------------
                    */

                    while (
                        str_contains(
                            $buffer,
                            "\n\n"
                        )
                    ) {

                        [
                            $eventBlock,
                            $buffer
                        ] =
                            explode(
                                "\n\n",
                                $buffer,
                                2
                            );


                        /*
                        |--------------------------------------------------------------------------
                        | Get event data
                        |--------------------------------------------------------------------------
                        */

                        $eventData =
                            null;


                        $eventName =
                            null;


                        foreach (
                            preg_split(
                                "/\r\n|\r|\n/",
                                $eventBlock
                            )
                            as $line
                        ) {

                            if (
                                str_starts_with(
                                    $line,
                                    'event:'
                                )
                            ) {

                                $eventName =
                                    trim(
                                        substr(
                                            $line,
                                            6
                                        )
                                    );

                            }


                            if (
                                str_starts_with(
                                    $line,
                                    'data:'
                                )
                            ) {

                                $eventData =
                                    trim(
                                        substr(
                                            $line,
                                            5
                                        )
                                    );

                            }

                        }


                        if (!$eventData) {
                            continue;
                        }


                        /*
                        |--------------------------------------------------------------------------
                        | DONE event
                        |--------------------------------------------------------------------------
                        */

                        if (
                            $eventData ===
                            '[DONE]'
                        ) {

                            continue;

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Decode JSON
                        |--------------------------------------------------------------------------
                        */

                        $json =
                            json_decode(
                                $eventData,
                                true
                            );


                        if (
                            !is_array(
                                $json
                            )
                        ) {

                            continue;

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Gemini error event
                        |--------------------------------------------------------------------------
                        */

                        if (
                            $eventName ===
                            'error'
                        ) {

                            $sendEvent(
                                'error',
                                [

                                    'message' =>
                                        $json['error']['message']
                                        ??
                                        'Gemini returned an error.',

                                    'details' =>
                                        $json,

                                ]
                            );

                            continue;

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Interaction created
                        |--------------------------------------------------------------------------
                        */

                        if (
                            $eventName ===
                            'interaction.created'
                        ) {

                            $sendEvent(
                                'status',
                                [

                                    'message' =>
                                        'Gemini is creating your portrait...',

                                    'interaction_id' =>
                                        $json['interaction']['id']
                                        ??
                                        null,

                                ]
                            );

                            continue;

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Status update
                        |--------------------------------------------------------------------------
                        */

                        if (
                            $eventName ===
                            'interaction.status_update'
                        ) {

                            $status =
                                $json['status']
                                ??
                                'in_progress';


                            $sendEvent(
                                'status',
                                [

                                    'message' =>
                                        'Gemini status: '
                                        .
                                        $status,

                                ]
                            );

                            continue;

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Step delta
                        |--------------------------------------------------------------------------
                        */

                        if (
                            $eventName ===
                            'step.delta'
                        ) {

                            $delta =
                                $json['delta']
                                ??
                                [];


                            $deltaType =
                                $delta['type']
                                ??
                                null;


                            /*
                            |--------------------------------------------------------------------------
                            | Image data
                            |--------------------------------------------------------------------------
                            */

                            if (
                                $deltaType ===
                                'image'
                            ) {

                                /*
                                |--------------------------------------------------------------------------
                                | Gemini image data
                                |--------------------------------------------------------------------------
                                |
                                | According to Google's streaming format,
                                | image data is Base64 encoded.
                                |
                                */

                                $imageData =
                                    $delta['data']
                                    ??
                                    null;


                                $imageMimeType =
                                    $delta['mime_type']
                                    ??
                                    'image/jpeg';


                                $sendEvent(
                                    'status',
                                    [

                                        'message' =>
                                            'Image generated! Saving your portrait...'

                                    ]
                                );

                            }

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Interaction completed
                        |--------------------------------------------------------------------------
                        */

                        if (
                            $eventName ===
                            'interaction.completed'
                        ) {

                            $sendEvent(
                                'status',
                                [

                                    'message' =>
                                        'Gemini completed the generation.'

                                ]
                            );

                        }

                    }

                }


                /*
                |--------------------------------------------------------------------------
                | Check image
                |--------------------------------------------------------------------------
                */

                if (!$imageData) {

                    $sendEvent(
                        'error',
                        [

                            'message' =>
                                'Gemini completed the request but no image was received.',

                        ]
                    );

                    return;

                }


                /*
                |--------------------------------------------------------------------------
                | Decode Base64 image
                |--------------------------------------------------------------------------
                */

                $image =
                    base64_decode(
                        $imageData,
                        true
                    );


                if (
                    $image === false
                ) {

                    $sendEvent(
                        'error',
                        [

                            'message' =>
                                'Unable to decode the generated image.',

                        ]
                    );

                    return;

                }


                /*
                |--------------------------------------------------------------------------
                | Determine extension
                |--------------------------------------------------------------------------
                */

                $extension =
                    'jpg';


                if (
                    str_contains(
                        $imageMimeType,
                        'png'
                    )
                ) {

                    $extension =
                        'png';

                } elseif (
                    str_contains(
                        $imageMimeType,
                        'webp'
                    )
                ) {

                    $extension =
                        'webp';

                }


                /*
                |--------------------------------------------------------------------------
                | Save image
                |--------------------------------------------------------------------------
                */

                $filename =
                    'ai-portraits/'
                    .
                    uniqid(
                        'portrait_'
                    )
                    .
                    '.'
                    .
                    $extension;


                try {

                    Storage::disk(
                        'public'
                    )->put(
                        $filename,
                        $image
                    );

                } catch (
                    \Throwable $e
                ) {

                    $sendEvent(
                        'error',
                        [

                            'message' =>
                                'Unable to save generated image.',

                            'details' =>
                                $e->getMessage(),

                        ]
                    );

                    return;

                }


                /*
                |--------------------------------------------------------------------------
                | Success
                |--------------------------------------------------------------------------
                */

                $sendEvent(
                    'complete',
                    [

                        'success' =>
                            true,

                        'theme' =>
                            $theme,

                        'image_url' =>
                            Storage::url(
                                $filename
                            ),

                    ]
                );


                /*
                |--------------------------------------------------------------------------
                | Finish stream
                |--------------------------------------------------------------------------
                */

                echo "event: done\n";
                echo "data: [DONE]\n\n";

                flush();

            },

            200,

            [

                'Content-Type' =>
                    'text/event-stream',

                'Cache-Control' =>
                    'no-cache, no-store, must-revalidate',

                'X-Accel-Buffering' =>
                    'no',

                'Connection' =>
                    'keep-alive',

            ]
        );
    }
}