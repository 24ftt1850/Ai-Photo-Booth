<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Creating Your Photo - RupaVue</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            width: 100%;
            min-height: 100%;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #111;
            color: white;
        }

        /* =========================
           MAIN PAGE
        ========================= */

        .generate-page {
            min-height: 100vh;
            width: 100%;

            background:
                linear-gradient(
                    rgba(0, 0, 0, 0.60),
                    rgba(0, 0, 0, 0.82)
                ),
                url('/images/demo-background.jpg');

            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;

            padding: 30px 5% 45px;

            display: flex;
            flex-direction: column;
        }

        /* =========================
           HEADER
        ========================= */

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;

            margin-bottom: 35px;
        }

        .logo {
            font-size: 25px;
            font-weight: 800;

            letter-spacing: 4px;
        }

        .step {
            font-size: 13px;
            font-weight: 600;

            letter-spacing: 2px;

            color: rgba(255, 255, 255, 0.65);
        }

        /* =========================
           TITLE
        ========================= */

        .title-section {
            text-align: center;

            margin-bottom: 30px;
        }

        .title-section h1 {
            font-size: clamp(30px, 4vw, 50px);

            font-weight: 700;

            margin-bottom: 10px;
        }

        .title-section p {
            font-size: 15px;

            color: rgba(255, 255, 255, 0.7);
        }

        /* =========================
           THEME
        ========================= */

        .theme-label {
            text-align: center;

            margin-bottom: 25px;
        }

        .theme-label span {
            display: inline-block;

            padding: 8px 18px;

            border: 1px solid rgba(255, 255, 255, 0.2);

            border-radius: 50px;

            background: rgba(255, 255, 255, 0.08);

            font-size: 13px;

            letter-spacing: 1px;
        }

        /* =========================
           GENERATION AREA
        ========================= */

        .generation-container {
            width: 100%;
            max-width: 1000px;

            margin: 0 auto;

            display: grid;

            grid-template-columns:
                1fr 120px 1fr;

            align-items: center;

            gap: 30px;
        }

        /* =========================
           PHOTO
        ========================= */

        .photo-container {
            display: flex;

            flex-direction: column;

            align-items: center;
        }

        .photo-title {
            font-size: 13px;

            letter-spacing: 1.5px;

            text-transform: uppercase;

            color: rgba(255, 255, 255, 0.65);

            margin-bottom: 12px;
        }

        .photo-frame {
            width: min(100%, 330px);

            aspect-ratio: 2 / 3;

            border-radius: 18px;

            overflow: hidden;

            background: #151515;

            border: 2px solid rgba(255, 255, 255, 0.15);

            box-shadow:
                0 15px 45px rgba(0, 0, 0, 0.45);

            position: relative;
        }

        .photo-frame img {
            width: 100%;
            height: 100%;

            display: block;

            object-fit: cover;
        }

        .photo-placeholder {
            width: 100%;
            height: 100%;

            display: flex;

            align-items: center;
            justify-content: center;

            flex-direction: column;

            color: rgba(255, 255, 255, 0.4);

            text-align: center;
        }

        .photo-placeholder-icon {
            font-size: 45px;

            margin-bottom: 12px;
        }

        .photo-placeholder p {
            font-size: 13px;
        }

        /* =========================
           ARROW
        ========================= */

        .arrow {
            display: flex;

            align-items: center;
            justify-content: center;

            font-size: 38px;

            color: rgba(255, 255, 255, 0.6);
        }

        /* =========================
           AI LOADING
        ========================= */

        .ai-status {
            margin-top: 30px;

            text-align: center;
        }

        .loading-circle {
            width: 55px;
            height: 55px;

            margin: 0 auto 18px;

            border-radius: 50%;

            border: 4px solid rgba(255, 255, 255, 0.2);

            border-top-color: white;

            animation:
                spin 1s linear infinite;
        }

        @keyframes spin {

            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }

        }

        .ai-status h2 {
            font-size: 20px;

            margin-bottom: 8px;
        }

        .ai-status p {
            font-size: 14px;

            color: rgba(255, 255, 255, 0.6);
        }

        /* =========================
           PROGRESS
        ========================= */

        .progress-container {
            width: min(90%, 450px);

            margin: 25px auto 0;
        }

        .progress-bar {
            width: 100%;

            height: 5px;

            border-radius: 10px;

            overflow: hidden;

            background: rgba(255, 255, 255, 0.15);
        }

        .progress-fill {
            width: 0%;

            height: 100%;

            background: white;

            border-radius: 10px;

            transition: width 0.5s ease;
        }

        .progress-text {
            text-align: center;

            margin-top: 8px;

            font-size: 12px;

            color: rgba(255, 255, 255, 0.55);
        }

        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 800px) {

            .generation-container {
                grid-template-columns: 1fr;

                gap: 20px;
            }

            .arrow {
                transform: rotate(90deg);

                font-size: 30px;
            }

            .photo-frame {
                width: min(70vw, 300px);
            }

        }

        @media (max-width: 480px) {

            .generate-page {
                padding: 25px 20px 35px;
            }

            .logo {
                font-size: 20px;
            }

            .step {
                font-size: 10px;
            }

            .title-section h1 {
                font-size: 30px;
            }

            .title-section p {
                font-size: 13px;
            }

            .photo-frame {
                width: min(75vw, 270px);
            }

        }
    </style>
</head>

<body>

<div class="generate-page">

    <!-- =========================
         HEADER
    ========================== -->

    <header class="header">

        <div class="logo">
            RUPAVUE
        </div>

        <div class="step">
            STEP 3 OF 3
        </div>

    </header>


    <!-- =========================
         TITLE
    ========================== -->

    <section class="title-section">

        <h1>
            Creating Your Photo
        </h1>

        <p>
            Our AI is transforming your photo.
        </p>

    </section>


    <!-- =========================
         THEME
    ========================== -->

    <div class="theme-label">

        <span>
            Theme:
            <strong id="themeName">
                {{ $theme->name ?? 'Unknown Theme' }}
            </strong>
        </span>

    </div>


    <!-- =========================
         PHOTO COMPARISON
    ========================== -->

    <div class="generation-container">

        <!-- ORIGINAL -->

        <div class="photo-container">

            <div class="photo-title">
                Your Photo
            </div>

            <div class="photo-frame">

                <img
                    id="originalPhoto"
                    alt="Your captured photo"
                    style="display: none;"
                >

                <div
                    class="photo-placeholder"
                    id="photoPlaceholder"
                >

                    <div class="photo-placeholder-icon">
                        📷
                    </div>

                    <p>
                        Preparing your photo...
                    </p>

                </div>

            </div>

        </div>


        <!-- ARROW -->

        <div class="arrow">
            →
        </div>


        <!-- GENERATED -->

        <div class="photo-container">

            <div class="photo-title">
                AI Result
            </div>

            <div class="photo-frame">

                <div class="photo-placeholder">

                    <div class="loading-circle"></div>

                    <p>
                        AI is creating...
                    </p>

                </div>

            </div>

        </div>

    </div>


    <!-- =========================
         STATUS
    ========================== -->

    <div class="ai-status">

        <div class="loading-circle"></div>

        <h2>
            Applying AI Magic
        </h2>

        <p id="statusText">
            Preparing your image...
        </p>

    </div>


    <!-- =========================
         PROGRESS
    ========================== -->

    <div class="progress-container">

        <div class="progress-bar">

            <div
                class="progress-fill"
                id="progressFill"
            ></div>

        </div>

        <div
            class="progress-text"
            id="progressText"
        >
            0%
        </div>

    </div>

</div>


<script>

    /*
     * =========================
     * ELEMENTS
     * =========================
     */

    const originalPhoto =
        document.getElementById('originalPhoto');

    const photoPlaceholder =
        document.getElementById('photoPlaceholder');

    const statusText =
        document.getElementById('statusText');

    const progressFill =
        document.getElementById('progressFill');

    const progressText =
        document.getElementById('progressText');


    /*
     * =========================
     * THEME (RESOLVED SERVER-SIDE)
     * =========================
     */

    const themeId =
        @json($theme->id ?? null);


    /*
     * =========================
     * LOAD CAPTURED PHOTO
     * =========================
     */

    const capturedPhoto =
        sessionStorage.getItem(
            'rupavueCapturedPhoto'
        );


    if (capturedPhoto) {

        originalPhoto.src =
            capturedPhoto;

        originalPhoto.style.display =
            'block';

        photoPlaceholder.style.display =
            'none';

    } else {

        statusText.textContent =
            'No captured photo found.';

    }


    /*
    |--------------------------------------------------------------------------
    | Progress
    |--------------------------------------------------------------------------
    */

    function updateProgress(
        value,
        message
    ) {

        progressFill.style.width =
            value + '%';

        progressText.textContent =
            value + '%';

        statusText.textContent =
            message;

    }


    /*
    |--------------------------------------------------------------------------
    | Wait Helper
    |--------------------------------------------------------------------------
    */

    function wait(milliseconds) {

        return new Promise(
            resolve =>
                setTimeout(
                    resolve,
                    milliseconds
                )
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Generate AI Image
    |--------------------------------------------------------------------------
    */

    async function generateAIImage() {

        if (!capturedPhoto) {

            statusText.textContent =
                'No photo was captured.';

            return;

        }


        if (!themeId) {

            statusText.textContent =
                'No theme was selected.';

            return;

        }


        try {

            updateProgress(
                10,
                'Preparing your photo...'
            );


            await wait(500);


            updateProgress(
                25,
                'Uploading your photo...'
            );


            /*
            * Send photo + theme to Laravel
            */

            const response =
                await fetch(
                    "{{ route('gemini.generate') }}",
                    {

                        method: 'POST',

                        headers: {

                            'Content-Type':
                                'application/json',

                            'X-CSRF-TOKEN':
                                '{{ csrf_token() }}',

                            'Accept':
                                'application/json'

                        },

                        body: JSON.stringify({

                            image:
                                capturedPhoto,

                            theme_id:
                                themeId

                        })

                    }
                );


            updateProgress(
                45,
                'AI is creating your photo...'
            );


            const data =
                await response.json();


            /*
            * Check response
            */

            if (!response.ok ||
                !data.success) {

                console.error(
                    'Generation error:',
                    data
                );

                throw new Error(
                    data.message ||
                    'AI generation failed.'
                );

            }


            updateProgress(
                90,
                'Finishing your photo...'
            );


            /*
            * Save generated image
            */

            sessionStorage.setItem(
                'rupavueGeneratedPhoto',
                data.generated_image
            );


            sessionStorage.setItem(
                'rupavueGeneratedImageId',
                data.generated_image_id
            );


            sessionStorage.setItem(
                'rupavueOriginalPhoto',
                data.original_image
            );


            sessionStorage.setItem(
                'rupavueThemeName',
                data.theme
            );


            await wait(700);


            updateProgress(
                100,
                'Your photo is ready!'
            );


            await wait(500);


            /*
            * Go to result
            */

            window.location.href =
                "{{ route('photobooth.result') }}";


        } catch (error) {

            console.error(
                error
            );


            statusText.textContent =
                error.message ||
                'Something went wrong while creating your photo.';


            progressText.textContent =
                'Error';


            progressFill.style.width =
                '0%';

        }

    }


    /*
    |--------------------------------------------------------------------------
    | Start Generation
    |--------------------------------------------------------------------------
    */

    generateAIImage();

</script>

</body>
</html>