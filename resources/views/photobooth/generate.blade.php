<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Creating AI Portrait</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    <style>

        * {
            box-sizing: border-box;
        }

        body {

            margin: 0;

            font-family:
                Arial,
                sans-serif;

            background:
                #0f172a;

            color:
                white;

        }

        .page {

            min-height: 100vh;

            display:
                flex;

            align-items:
                center;

            justify-content:
                center;

            padding:
                30px;

        }

        .card {

            width:
                100%;

            max-width:
                650px;

            background:
                #1e293b;

            border-radius:
                24px;

            padding:
                50px 40px;

            text-align:
                center;

            box-shadow:
                0 25px 70px
                rgba(0,0,0,0.4);

        }

        .icon {

            width:
                100px;

            height:
                100px;

            margin:
                0 auto 30px;

            border-radius:
                30px;

            display:
                flex;

            align-items:
                center;

            justify-content:
                center;

            font-size:
                45px;

            background:
                linear-gradient(
                    135deg,
                    #7c3aed,
                    #06b6d4
                );

            animation:
                glow 2s infinite;

        }

        @keyframes glow {

            0% {

                transform:
                    scale(1);

                box-shadow:
                    0 0 0
                    rgba(124,58,237,0);

            }

            50% {

                transform:
                    scale(1.05);

                box-shadow:
                    0 0 40px
                    rgba(124,58,237,0.4);

            }

            100% {

                transform:
                    scale(1);

                box-shadow:
                    0 0 0
                    rgba(124,58,237,0);

            }

        }

        h1 {

            margin:
                0;

            font-size:
                32px;

        }

        .description {

            margin-top:
                15px;

            color:
                #94a3b8;

            line-height:
                1.6;

        }

        .theme {

            display:
                inline-block;

            margin-top:
                25px;

            padding:
                10px 18px;

            border-radius:
                30px;

            background:
                #334155;

            color:
                #c4b5fd;

            font-weight:
                bold;

        }

        .loader {

            display:
                flex;

            justify-content:
                center;

            gap:
                8px;

            margin-top:
                35px;

        }

        .dot {

            width:
                10px;

            height:
                10px;

            border-radius:
                50%;

            background:
                #8b5cf6;

            animation:
                loading 1.4s
                infinite
                ease-in-out;

        }

        .dot:nth-child(2) {

            animation-delay:
                0.2s;

        }

        .dot:nth-child(3) {

            animation-delay:
                0.4s;

        }

        @keyframes loading {

            0%,
            80%,
            100% {

                transform:
                    scale(0.6);

                opacity:
                    0.4;

            }

            40% {

                transform:
                    scale(1);

                opacity:
                    1;

            }

        }

        .status {

            margin-top:
                25px;

            color:
                #94a3b8;

            font-size:
                14px;

            min-height:
                20px;

        }

        .timer {

            margin-top:
                10px;

            color:
                #64748b;

            font-size:
                13px;

        }

        .cancel {

            margin-top:
                30px;

            padding:
                12px 20px;

            border:
                none;

            border-radius:
                10px;

            background:
                #334155;

            color:
                white;

            cursor:
                pointer;

            font-size:
                14px;

        }

        .cancel:hover {

            background:
                #475569;

        }

        .cancel:disabled {

            opacity:
                0.5;

            cursor:
                not-allowed;

        }

    </style>

</head>


<body>

<div class="page">

    <div class="card">

        <div class="icon">
            ✨
        </div>


        <h1>
            Creating Your AI Portrait
        </h1>


        <p class="description">

            Gemini is transforming your
            photo into your selected theme.

        </p>


        <div
            id="theme"
            class="theme"
        >
            Preparing...
        </div>


        <div class="loader">

            <div class="dot"></div>

            <div class="dot"></div>

            <div class="dot"></div>

        </div>


        <div
            id="status"
            class="status"
        >
            Starting AI generation...
        </div>


        <div
            id="timer"
            class="timer"
        >
            0 seconds
        </div>


        <button
            id="cancelButton"
            class="cancel"
            onclick="goBack()"
        >
            ← Go Back
        </button>

    </div>

</div>


<script>

/*
|--------------------------------------------------------------------------
| Get stored photo and theme
|--------------------------------------------------------------------------
*/

const photo =
    sessionStorage.getItem(
        'photobooth_photo'
    );


const selectedTheme =
    sessionStorage.getItem(
        'selected_scene'
    );


/*
|--------------------------------------------------------------------------
| UI
|--------------------------------------------------------------------------
*/

const themeElement =
    document.getElementById(
        'theme'
    );


const statusElement =
    document.getElementById(
        'status'
    );


const timerElement =
    document.getElementById(
        'timer'
    );


const cancelButton =
    document.getElementById(
        'cancelButton'
    );


/*
|--------------------------------------------------------------------------
| Check photo
|--------------------------------------------------------------------------
*/

if (!photo) {

    statusElement.textContent =
        'No photo was found.';

    throw new Error(
        'Photo not found.'
    );

}


/*
|--------------------------------------------------------------------------
| Check theme
|--------------------------------------------------------------------------
*/

if (!selectedTheme) {

    statusElement.textContent =
        'No theme was selected.';

    throw new Error(
        'Theme not found.'
    );

}


/*
|--------------------------------------------------------------------------
| Parse theme
|--------------------------------------------------------------------------
*/

let theme;

try {

    theme =
        JSON.parse(
            selectedTheme
        );

} catch (error) {

    statusElement.textContent =
        'Invalid theme information.';

    throw error;

}


/*
|--------------------------------------------------------------------------
| Theme prompts
|--------------------------------------------------------------------------
*/

const themePrompts = {

    graduation: `
        Transform the person in the provided photo
        into a professional graduation portrait.

        The person should be wearing an elegant
        graduation cap and gown.

        Create a beautiful university graduation
        environment with professional studio
        photography.

        Use realistic lighting, natural skin,
        detailed facial features and a
        photorealistic appearance.

        Preserve the person's identity.
        Preserve the person's facial features.
    `,


    spiderman: `
        Transform the person in the provided photo
        into a cinematic Spider-Man inspired
        superhero environment.

        Keep the person's face recognizable
        and preserve their identity.

        Create a dramatic futuristic city
        environment with tall buildings,
        dramatic lighting and atmospheric effects.

        Make the image cinematic, realistic
        and highly detailed.

        Do not replace the person's face.
        Do not add extra people.
    `,


    mafia: `
        Transform the person in the provided photo
        into a cinematic classic mafia portrait.

        Place the person in an elegant dark
        crime-drama environment.

        Use a sophisticated black suit,
        dramatic cinematic lighting,
        dark luxury surroundings and
        professional photography.

        Keep the person's face recognizable
        and preserve their identity.

        Make the result photorealistic,
        cinematic and highly detailed.

        Do not add extra people.
    `

};


/*
|--------------------------------------------------------------------------
| Theme name
|--------------------------------------------------------------------------
*/

const themeName =
    String(
        theme.name || ''
    )
    .toLowerCase()
    .trim();


/*
|--------------------------------------------------------------------------
| Get prompt
|--------------------------------------------------------------------------
*/

const selectedPrompt =
    themePrompts[
        themeName
    ];


if (!selectedPrompt) {

    statusElement.textContent =
        'Unsupported theme.';

    alert(
        'Unsupported theme: '
        + themeName
    );

    throw new Error(
        'Unsupported theme.'
    );

}


/*
|--------------------------------------------------------------------------
| Display theme
|--------------------------------------------------------------------------
*/

themeElement.textContent =

    themeName
        .charAt(0)
        .toUpperCase()

    +

    themeName.slice(1);


/*
|--------------------------------------------------------------------------
| Variables
|--------------------------------------------------------------------------
*/

let generationStarted =
    false;

let elapsedSeconds =
    0;

let timerInterval =
    null;


/*
|--------------------------------------------------------------------------
| Timer
|--------------------------------------------------------------------------
*/

function startTimer() {

    elapsedSeconds =
        0;


    timerInterval =
        setInterval(
            () => {

                elapsedSeconds++;


                timerElement.textContent =
                    elapsedSeconds
                    + ' seconds';

            },
            1000
        );

}


function stopTimer() {

    if (
        timerInterval
    ) {

        clearInterval(
            timerInterval
        );

        timerInterval =
            null;

    }

}


/*
|--------------------------------------------------------------------------
| Status
|--------------------------------------------------------------------------
*/

function updateStatus(
    message
) {

    statusElement.textContent =
        message;

}


/*
|--------------------------------------------------------------------------
| Go back
|--------------------------------------------------------------------------
*/

function goBack() {

    if (
        generationStarted
    ) {

        const confirmed =
            confirm(
                'AI generation is still running. Are you sure you want to leave?'
            );


        if (!confirmed) {

            return;

        }

    }


    stopTimer();


    window.location.href =
        "{{ route('photobooth.scene') }}";

}


/*
|--------------------------------------------------------------------------
| Generate portrait
|--------------------------------------------------------------------------
*/

async function generatePortrait() {

    if (
        generationStarted
    ) {

        return;

    }


    generationStarted =
        true;


    cancelButton.disabled =
        true;


    startTimer();


    updateStatus(
        'Connecting to Gemini...'
    );


    try {


        /*
        |--------------------------------------------------------------------------
        | Send request
        |--------------------------------------------------------------------------
        */

        const response =
            await fetch(

                "{{ route('gemini.generate') }}",

                {

                    method:
                        'POST',

                    headers: {

                        'Content-Type':
                            'application/json',

                        'X-CSRF-TOKEN':
                            "{{ csrf_token() }}",

                        'Accept':
                            'text/event-stream'

                    },

                    body:
                        JSON.stringify({

                            photo:
                                photo,

                            theme:
                                themeName,

                            prompt:
                                selectedPrompt

                        })

                }

            );


        /*
        |--------------------------------------------------------------------------
        | Check HTTP status
        |--------------------------------------------------------------------------
        */

        if (
            !response.ok
        ) {

            const errorText =
                await response.text();

            throw new Error(
                errorText
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Get stream reader
        |--------------------------------------------------------------------------
        */

        const reader =
            response.body.getReader();


        const decoder =
            new TextDecoder();


        let buffer =
            '';


        /*
        |--------------------------------------------------------------------------
        | Read stream
        |--------------------------------------------------------------------------
        */

        while (true) {

            const {
                value,
                done
            } =
                await reader.read();


            if (done) {

                break;

            }


            buffer +=
                decoder.decode(
                    value,
                    {
                        stream:
                            true
                    }
                );


            /*
            |--------------------------------------------------------------------------
            | SSE events separated by blank line
            |--------------------------------------------------------------------------
            */

            const events =
                buffer.split(
                    /\r?\n\r?\n/
                );


            buffer =
                events.pop();


            /*
            |--------------------------------------------------------------------------
            | Process events
            |--------------------------------------------------------------------------
            */

            for (
                const eventBlock
                of events
            ) {


                const lines =
                    eventBlock.split(
                        /\r?\n/
                    );


                let eventName =
                    'message';


                let eventData =
                    '';


                for (
                    const line
                    of lines
                ) {

                    if (
                        line.startsWith(
                            'event:'
                        )
                    ) {

                        eventName =
                            line
                                .substring(6)
                                .trim();

                    }


                    if (
                        line.startsWith(
                            'data:'
                        )
                    ) {

                        eventData +=
                            line
                                .substring(5)
                                .trim();

                    }

                }


                if (
                    !eventData
                ) {

                    continue;

                }


                if (
                    eventData ===
                    '[DONE]'
                ) {

                    continue;

                }


                let data;


                try {

                    data =
                        JSON.parse(
                            eventData
                        );

                } catch (error) {

                    console.warn(
                        'Invalid SSE data:',
                        eventData
                    );

                    continue;

                }


                /*
                |--------------------------------------------------------------------------
                | Status event
                |--------------------------------------------------------------------------
                */

                if (
                    eventName ===
                    'status'
                ) {

                    updateStatus(
                        data.message
                        ||
                        'Gemini is generating your portrait...'
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | Error event
                |--------------------------------------------------------------------------
                */

                if (eventName === 'error') {

                    console.error(
                        'GEMINI SERVER ERROR:',
                        data
                    );

                    throw new Error(

                        (data.message || 'Gemini generation failed.')

                        +

                        '\n\nDetails:\n'

                        +

                        (
                            data.details
                            || 'No additional details.'
                        )

                    );

                }


                /*
                |--------------------------------------------------------------------------
                | Complete event
                |--------------------------------------------------------------------------
                */

                if (
                    eventName ===
                    'complete'
                ) {

                    if (
                        !data.success
                        ||
                        !data.image_url
                    ) {

                        throw new Error(
                            'Gemini did not return a generated image.'
                        );

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Stop timer
                    |--------------------------------------------------------------------------
                    */

                    stopTimer();


                    updateStatus(
                        'Portrait generated successfully!'
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | Save result
                    |--------------------------------------------------------------------------
                    */

                    sessionStorage.setItem(
                        'generated_image',
                        data.image_url
                    );


                    sessionStorage.setItem(
                        'generated_theme',
                        themeName
                    );


                    sessionStorage.setItem(
                        'generated_image_id',
                        data.generated_image_id
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | Move to result
                    |--------------------------------------------------------------------------
                    */

                    setTimeout(
                        () => {

                            window.location.href =
                                "{{ route('photobooth.result') }}";

                        },
                        500
                    );

                }

            }

        }


    } catch (error) {


        /*
        |--------------------------------------------------------------------------
        | Error
        |--------------------------------------------------------------------------
        */

        console.error(
            'GEMINI STREAM ERROR:',
            error
        );


        stopTimer();


        generationStarted =
            false;


        cancelButton.disabled =
            false;


        updateStatus(
            'Generation failed.'
        );


        alert(
            'Gemini Error\n\n'
            +
            error.message
        );

    }

}


/*
|--------------------------------------------------------------------------
| Start
|--------------------------------------------------------------------------
*/

generatePortrait();

</script>

</body>

</html>